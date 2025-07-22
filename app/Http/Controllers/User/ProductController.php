<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\{ProductVariant, Brand, Origin, Attribute, AttributeValue};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = ProductVariant::with([
            'product.brand',
            'product.origin', 
            'product.category',
            'product.thumbnails',
            'variantAttributeValues.attribute',
            'variantAttributeValues.attributeValue'
        ]);

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search')) {
           $search = $request->search;
            $query->whereHas('product', function (Builder $q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $brands = $request->brand;
            $query->whereHas('product.brand', function (Builder $q) use ($brands) {
                $q->whereIn('name', $brands);
            });
        }

        // Lọc theo xuất xứ
        if ($request->filled('origin')) {
            $query->whereHas('product.origin', function (Builder $q) use ($request) {
                $q->where('country', $request->origin);
            });
        }

        // Lọc theo màu sắc
        if ($request->filled('color')) {
            $query->whereHas('variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%màu%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->color}%");
                });
            });
        }

        // Lọc theo kích thước màn hình
        if ($request->filled('screen_size')) {
            $query->whereHas('variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%màn hình%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->screen_size}%");
                });
            });
        }

        // Lọc theo RAM
        if ($request->filled('ram')) {
            $query->whereHas('variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%RAM%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->ram}%");
                });
            });
        }

        // Lọc theo lưu trữ
        if ($request->filled('storage')) {
            $query->whereHas('variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%lưu trữ%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->storage}%");
                });
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        // Chỉ hiển thị sản phẩm có số lượng > 0
        $query->where('quantity', '>', 0);

        // Sắp xếp
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('product.name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('product.name', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('user.pages.product-list', compact('products'));
    }

    public function show($id)
    {
        $product = ProductVariant::with([
            'product.brand',
            'product.origin',
            'product.category', 
            'product.thumbnails',
            'variantAttributeValues.attribute',
            'variantAttributeValues.attributeValue'
        ])->findOrFail($id);

        // Lấy các biến thể khác của cùng sản phẩm
        $relatedVariants = ProductVariant::with([
            'product.thumbnails',
            'variantAttributeValues.attribute',
            'variantAttributeValues.attributeValue'
        ])
        ->where('product_id', $product->product_id)
        ->where('id', '!=', $id)
        ->where('quantity', '>', 0)
        ->get();

        return view('user.pages.product-detail', compact('product', 'relatedVariants'));
    }
}
