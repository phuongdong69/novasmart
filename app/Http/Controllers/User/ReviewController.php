<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\{Comment, Rating, Order};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ReviewController extends Controller
{
    public function historyReviews()
{
    $userId = Auth::id();

    // Lọc rating có status active & type review
    $ratings = Rating::with(['productVariant.product', 'status'])
        ->where('user_id', $userId)
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->orderByDesc('created_at')
        ->get();

    // Lọc comment khớp rating + status active & type review
    $comments = Comment::with('status')
        ->where('user_id', $userId)
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->whereIn('order_detail_id', $ratings->pluck('order_detail_id'))
        ->get()
        ->mapWithKeys(function ($comment) {
            return [$comment->user_id . '-' . $comment->order_detail_id => $comment];
        });

    return view('user.pages.history-review', compact('ratings', 'comments'));
}

   public function show(Product $product, Request $request)
{
    $variantId = $product->variants->first()->id;

    $ratings = Rating::with(['user', 'status'])
        ->where('product_variant_id', $variantId)
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->when($request->filled('star') && $request->star !== 'all', function ($query) use ($request) {
            $query->where('rating', (int) $request->star);
        })
        ->orderByDesc('created_at')
        ->get();

    // Lấy comment khớp user + variant + status
    $comments = Comment::with('status')
        ->whereIn('user_id', $ratings->pluck('user_id'))
        ->where('product_variant_id', $variantId)
        ->whereHas('status', function ($q) {
            $q->where('code', 'active')->where('type', 'review');
        })
        ->get()
        ->mapWithKeys(function ($comment) {
            return [$comment->user_id . '-' . $comment->order_detail_id => $comment];
        });

    if ($request->ajax()) {
        $html = view('user.pages.partials.reviews', compact('ratings', 'comments'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ]);
    }

    return view('user.pages.product-detail', compact('product', 'ratings', 'comments'));
}

    public function store(Request $request)
{
    Log::debug('Bắt đầu xử lý đánh giá', [
        'user_id' => Auth::id(),
        'data' => $request->all()
    ]);

    $request->validate([
        'product_variant_id' => 'required|exists:product_variants,id',
        'rating' => 'nullable|integer|min:1|max:5',
        'content' => 'nullable|string|max:1000',
    ]);

    $user = Auth::user();

    $order = Order::where('user_id', $user->id)
        ->whereHas('orderStatus', fn ($q) => $q->where('code', 'completed'))
        ->whereHas('orderDetails', fn ($q) =>
            $q->where('product_variant_id', $request->product_variant_id)
        )
        ->latest()
        ->first();

    if (!$order) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn chỉ có thể đánh giá sau khi hoàn tất đơn hàng.'
        ], 403);
    }

    $hasRated = Rating::where([
        'user_id' => $user->id,
        'product_variant_id' => $request->product_variant_id,
    ])->exists();

    $hasCommented = Comment::where([
        'user_id' => $user->id,
        'product_variant_id' => $request->product_variant_id,
    ])->exists();

    if (
        ($request->filled('rating') && $hasRated) ||
        ($request->filled('content') && $hasCommented)
    ) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn đã đánh giá hoặc bình luận sản phẩm này rồi.'
        ], 409);
    }

    $orderDetail = $order->orderDetails()
        ->where('product_variant_id', $request->product_variant_id)
        ->first();

    if (!$orderDetail) {
        return response()->json([
            'success' => false,
            'message' => 'Không thể xác định chi tiết đơn hàng.',
        ], 422);
    }

    $ratingModel = null;
    $commentModel = null;

    if ($request->filled('rating') && !$hasRated) {
        $ratingModel = Rating::create([
            'user_id' => $user->id,
            'product_variant_id' => $request->product_variant_id,
            'order_id' => $order->id,
            'order_detail_id' => $orderDetail->id,
            'rating' => $request->rating,
        ]);

        Log::info('Đã lưu rating', ['id' => $ratingModel->id]);
    }

    if ($request->filled('content') && !$hasCommented) {
        $commentModel = Comment::create([
            'user_id' => $user->id,
            'product_variant_id' => $request->product_variant_id,
            'order_id' => $order->id,
            'order_detail_id' => $orderDetail->id,
            'content' => $request->content,
        ]);

        Log::info('Đã lưu comment', ['id' => $commentModel->id]);
    }

    // Tính tổng quan đánh giá
    $ratings = Rating::where('product_variant_id', $request->product_variant_id)->get();
    $averageRating = round($ratings->avg('rating'), 1);
    $totalRatings = $ratings->count();
    $breakdown = [
        1 => $ratings->where('rating', 1)->count(),
        2 => $ratings->where('rating', 2)->count(),
        3 => $ratings->where('rating', 3)->count(),
        4 => $ratings->where('rating', 4)->count(),
        5 => $ratings->where('rating', 5)->count(),
    ];

    // Trả về phản hồi cho frontend
    return response()->json([
        'success' => true,
        'message' => 'Đánh giá của bạn đã được gửi thành công.',
        'data' => [
            'user_name' => $user->name,
            'initial' => strtoupper(mb_substr($user->name, 0, 1)),
            'rating' => $ratingModel?->rating,
            'image_user' => $user->image_user,
            'comment' => $commentModel?->content,
            'time' => now()->diffForHumans(),
            'summary' => [
                'average' => $averageRating,
                'total' => $totalRatings,
                'breakdown' => $breakdown,
            ]
        ]
    ]);
}
    public function ratingSummary(Product $product)
    {
        $ratings = $product->ratings;

        return response()->json([
            'success' => true,
            'summary' => [
                'average' => round($ratings->avg('rating'), 1),
                'total' => $ratings->count(),
                'breakdown' => [
                    1 => $ratings->where('rating', 1)->count(),
                    2 => $ratings->where('rating', 2)->count(),
                    3 => $ratings->where('rating', 3)->count(),
                    4 => $ratings->where('rating', 4)->count(),
                    5 => $ratings->where('rating', 5)->count(),
                ]
            ]
        ]);
    }
    public function destroy(Rating $rating)
{
    if ($rating->user_id !== Auth::id()) {
        abort(403);
    }

    // Xoá rating và comment liên quan
    Comment::where('user_id', Auth::id())
        ->where('product_variant_id', $rating->product_variant_id)
        ->delete();

    $rating->delete();

    return redirect()->back()->with('success', 'Đã xoá đánh giá thành công.');
}
}
