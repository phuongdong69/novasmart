<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Thêm sản phẩm vào wishlist
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id'
        ]);

        $user = Auth::user();
        
        // Kiểm tra xem sản phẩm đã có trong wishlist chưa
        $existingWishlist = Wishlist::where('user_id', $user->id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if ($existingWishlist) {
            return response()->json([
                'success' => false,
                'message' => 'Sản phẩm đã có trong danh sách yêu thích'
            ]);
        }

        Wishlist::create([
            'user_id' => $user->id,
            'product_variant_id' => $request->product_variant_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã thêm vào danh sách yêu thích'
        ]);
    }

    /**
     * Xóa sản phẩm khỏi wishlist
     */
    public function remove(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id'
        ]);

        $user = Auth::user();
        
        Wishlist::where('user_id', $user->id)
            ->where('product_variant_id', $request->product_variant_id)
            ->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa khỏi danh sách yêu thích'
        ]);
    }

    /**
     * Kiểm tra sản phẩm có trong wishlist không
     */
    public function check(Request $request)
    {
        $request->validate([
            'product_variant_id' => 'required|exists:product_variants,id'
        ]);

        $user = Auth::user();
        
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_variant_id', $request->product_variant_id)
            ->exists();

        return response()->json([
            'success' => true,
            'is_liked' => $exists
        ]);
    }

    /**
     * Lấy danh sách wishlist của user
     */
    public function index()
    {
        $user = Auth::user();
        $wishlists = $user->wishlists()->with(['productVariant.product.thumbnails'])->get();
        
        // Nếu request là AJAX, trả về HTML cho dropdown
        if (request()->ajax()) {
            $html = view('user.partials.wishlist-items', compact('wishlists'))->render();
            return response()->json(['html' => $html]);
        }
        
        return view('user.pages.wishlist', compact('wishlists'));
    }

    /**
     * Lấy số lượng wishlist items
     */
    public function count()
    {
        $user = Auth::user();
        $count = $user->wishlists()->count();
        
        return response()->json([
            'success' => true,
            'count' => $count
        ]);
    }
}
