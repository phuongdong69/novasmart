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
        $query = Product::with([
            'brand',
            'origin', 
            'category',
            'thumbnails',
            'variants' => function($q) {
                $q->where('quantity', '>', 0)
                  ->with(['variantAttributeValues.attribute', 'variantAttributeValues.attributeValue']);
            }
        ]);

        // Tìm kiếm theo tên sản phẩm
        if ($request->filled('search')) {
           $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        // Lọc theo thương hiệu
        if ($request->filled('brand')) {
            $brands = $request->brand;
            // Nếu brand là array (nhiều brand được chọn)
            if (is_array($brands)) {
                $query->whereHas('brand', function (Builder $q) use ($brands) {
                    $q->whereIn('name', $brands);
                });
            } else {
                // Nếu brand là string (một brand được chọn)
                $query->whereHas('brand', function (Builder $q) use ($brands) {
                    $q->where('name', 'like', '%' . $brands . '%');
                });
            }
        }

        // Lọc theo xuất xứ
        if ($request->filled('origin')) {
            $query->whereHas('origin', function (Builder $q) use ($request) {
                $q->where('country', $request->origin);
            });
        }

        // Lọc theo màu sắc
        if ($request->filled('color')) {
            $query->whereHas('variants.variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%màu%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->color}%");
                });
            });
        }

        // Lọc theo kích thước màn hình
        if ($request->filled('screen_size')) {
            $query->whereHas('variants.variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%màn hình%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->screen_size}%");
                });
            });
        }

        // Lọc theo RAM
        if ($request->filled('ram')) {
            $query->whereHas('variants.variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%RAM%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->ram}%");
                });
            });
        }

        // Lọc theo lưu trữ
        if ($request->filled('storage')) {
            $query->whereHas('variants.variantAttributeValues', function (Builder $q) use ($request) {
                $q->whereHas('attribute', function (Builder $attr) {
                    $attr->where('name', 'like', '%lưu trữ%');
                })->whereHas('attributeValue', function (Builder $val) use ($request) {
                    $val->where('value', 'like', "%{$request->storage}%");
                });
            });
        }

        // Lọc theo khoảng giá
        if ($request->filled('price_min')) {
            $query->whereHas('variants', function (Builder $q) use ($request) {
                $q->where('price', '>=', $request->price_min);
            });
        }
        if ($request->filled('price_max')) {
            $query->whereHas('variants', function (Builder $q) use ($request) {
                $q->where('price', '<=', $request->price_max);
            });
        }

        // Chỉ hiển thị sản phẩm có ít nhất một biến thể có số lượng > 0
        $query->whereHas('variants', function (Builder $q) {
            $q->where('quantity', '>', 0);
        });

        // Sắp xếp
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->where('product_variants.quantity', '>', 0)
                      ->orderBy('product_variants.price', 'asc')
                      ->select('products.*');
                break;
            case 'price_desc':
                $query->join('product_variants', 'products.id', '=', 'product_variants.product_id')
                      ->where('product_variants.quantity', '>', 0)
                      ->orderBy('product_variants.price', 'desc')
                      ->select('products.*');
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
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
