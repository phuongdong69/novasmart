<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use App\Models\Status;
use App\Models\Comment;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        // Khởi tạo query builder
        $query = Rating::with(['user', 'productVariant.product', 'status']);

        // Tìm kiếm theo từ khóa
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->whereHas('productVariant.product', function ($q) use ($keyword) {
                $q->where('name', 'like', "%$keyword%");
            });
        }

        // Phân trang
        $ratings = $query->orderByDesc('created_at')->paginate(10);

        // Lấy comment liên quan đến các rating (dựa trên user_id + order_detail_id)
        $comments = Comment::with('status')
            ->whereIn('user_id', $ratings->pluck('user_id'))
            ->whereIn('order_detail_id', $ratings->pluck('order_detail_id'))
            ->get()
            ->keyBy(function ($item) {
                return $item->user_id . '-' . $item->order_detail_id;
            });

        return view('admin.reviews.index', compact('ratings', 'comments'));
    }

    public function toggleStatus($id)
    {
        $rating = Rating::with('status')->findOrFail($id);

        $currentStatusCode = $rating->status->code;

        // Tìm status mới
        $newStatus = Status::where('code', $currentStatusCode === 'active' ? 'inactive' : 'active')
            ->where('type', 'review')
            ->first();

        if (!$newStatus) {
            return redirect()->back()->with('error', 'Không tìm thấy trạng thái phù hợp.');
        }

        // Cập nhật status cho Rating
        $rating->status_id = $newStatus->id;
        $rating->save();

        // Cập nhật status cho Comment liên quan
        $comment = Comment::where('user_id', $rating->user_id)
            ->where('order_detail_id', $rating->order_detail_id)
            ->first();

        if ($comment) {
            $comment->status_id = $newStatus->id;
            $comment->save();
        }

        return redirect()->back()->with('success', 'Đã cập nhật trạng thái cho đánh giá và bình luận.');
    }
}
