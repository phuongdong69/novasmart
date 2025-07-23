<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\{Product, ProductVariant, Brand, Category, Origin, Attribute, AttributeValue, VariantAttributeValue};

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo thương hiệu
        $brands = [
            'Apple' => Brand::firstOrCreate(['name' => 'Apple']),
            'Samsung' => Brand::firstOrCreate(['name' => 'Samsung']),
            'Dell' => Brand::firstOrCreate(['name' => 'Dell']),
            'HP' => Brand::firstOrCreate(['name' => 'HP']),
            'Lenovo' => Brand::firstOrCreate(['name' => 'Lenovo']),
            'Asus' => Brand::firstOrCreate(['name' => 'Asus']),
        ];

        // Tạo danh mục
        $categories = [
            'Laptop' => Category::firstOrCreate(['name' => 'Laptop']),
            'Điện thoại' => Category::firstOrCreate(['name' => 'Điện thoại']),
            'Máy tính bảng' => Category::firstOrCreate(['name' => 'Máy tính bảng']),
        ];

        // Tạo xuất xứ
        $origins = [
            'Trung Quốc' => Origin::firstOrCreate(['country' => 'Trung Quốc']),
            'Hàn Quốc' => Origin::firstOrCreate(['country' => 'Hàn Quốc']),
            'Nhật Bản' => Origin::firstOrCreate(['country' => 'Nhật Bản']),
            'Mỹ' => Origin::firstOrCreate(['country' => 'Mỹ']),
            'Malaysia' => Origin::firstOrCreate(['country' => 'Malaysia']),
            'Thái Lan' => Origin::firstOrCreate(['country' => 'Thái Lan']),
        ];

        // Tạo thuộc tính
        $attributes = [
            'Màu sắc' => Attribute::firstOrCreate(['name' => 'Màu sắc']),
            'Kích thước màn hình' => Attribute::firstOrCreate(['name' => 'Kích thước màn hình']),
            'RAM' => Attribute::firstOrCreate(['name' => 'RAM']),
            'Lưu trữ' => Attribute::firstOrCreate(['name' => 'Lưu trữ']),
        ];

        // Tạo giá trị thuộc tính
        $attributeValues = [];
        foreach ($attributes as $name => $attribute) {
            switch ($name) {
                case 'Màu sắc':
                    $values = ['Đỏ', 'Xanh dương', 'Xanh lá', 'Đen', 'Xám', 'Cam', 'Tím'];
                    break;
                case 'Kích thước màn hình':
                    $values = ['13"', '14"', '15"', '16"', '17"'];
                    break;
                case 'RAM':
                    $values = ['8GB', '16GB', '32GB', '64GB'];
                    break;
                case 'Lưu trữ':
                    $values = ['256GB', '512GB', '1TB', '2TB'];
                    break;
                default:
                    $values = [];
            }
            
            foreach ($values as $value) {
                $attributeValues[$name][$value] = AttributeValue::firstOrCreate([
                    'attribute_id' => $attribute->id,
                    'value' => $value
                ]);
            }
        }

        // Tạo sản phẩm
        $products = [
            [
                'name' => 'MacBook Pro 13 inch',
                'description' => 'Laptop cao cấp từ Apple với hiệu suất mạnh mẽ',
                'brand' => 'Apple',
                'category' => 'Laptop',
                'origin' => 'Mỹ',
                'variants' => [
                    [
                        'sku' => 'MBP13-8-256',
                        'price' => 25000000,
                        'quantity' => 10,
                        'attributes' => [
                            'Màu sắc' => 'Xám',
                            'RAM' => '8GB',
                            'Lưu trữ' => '256GB',
                        ]
                    ],
                    [
                        'sku' => 'MBP13-16-512',
                        'price' => 32000000,
                        'quantity' => 5,
                        'attributes' => [
                            'Màu sắc' => 'Xám',
                            'RAM' => '16GB',
                            'Lưu trữ' => '512GB',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Laptop siêu mỏng với thiết kế đẹp mắt',
                'brand' => 'Dell',
                'category' => 'Laptop',
                'origin' => 'Mỹ',
                'variants' => [
                    [
                        'sku' => 'XPS13-8-256',
                        'price' => 22000000,
                        'quantity' => 8,
                        'attributes' => [
                            'Màu sắc' => 'Đen',
                            'RAM' => '8GB',
                            'Lưu trữ' => '256GB',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Điện thoại thông minh mới nhất từ Samsung',
                'brand' => 'Samsung',
                'category' => 'Điện thoại',
                'origin' => 'Hàn Quốc',
                'variants' => [
                    [
                        'sku' => 'S24-8-256',
                        'price' => 18000000,
                        'quantity' => 15,
                        'attributes' => [
                            'Màu sắc' => 'Đen',
                            'RAM' => '8GB',
                            'Lưu trữ' => '256GB',
                        ]
                    ],
                    [
                        'sku' => 'S24-12-512',
                        'price' => 22000000,
                        'quantity' => 10,
                        'attributes' => [
                            'Màu sắc' => 'Xanh dương',
                            'RAM' => '12GB',
                            'Lưu trữ' => '512GB',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Lenovo ThinkPad X1',
                'description' => 'Laptop doanh nhân cao cấp',
                'brand' => 'Lenovo',
                'category' => 'Laptop',
                'origin' => 'Trung Quốc',
                'variants' => [
                    [
                        'sku' => 'X1-16-512',
                        'price' => 28000000,
                        'quantity' => 6,
                        'attributes' => [
                            'Màu sắc' => 'Đen',
                            'RAM' => '16GB',
                            'Lưu trữ' => '512GB',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'HP Pavilion',
                'description' => 'Laptop phổ thông với giá cả hợp lý',
                'brand' => 'HP',
                'category' => 'Laptop',
                'origin' => 'Thái Lan',
                'variants' => [
                    [
                        'sku' => 'PAV-8-256',
                        'price' => 15000000,
                        'quantity' => 12,
                        'attributes' => [
                            'Màu sắc' => 'Xám',
                            'RAM' => '8GB',
                            'Lưu trữ' => '256GB',
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Asus ROG Strix',
                'description' => 'Laptop gaming hiệu suất cao',
                'brand' => 'Asus',
                'category' => 'Laptop',
                'origin' => 'Malaysia',
                'variants' => [
                    [
                        'sku' => 'ROG-16-1TB',
                        'price' => 35000000,
                        'quantity' => 4,
                        'attributes' => [
                            'Màu sắc' => 'Đen',
                            'RAM' => '16GB',
                            'Lưu trữ' => '1TB',
                        ]
                    ]
                ]
            ]
        ];

        // Tạo sản phẩm và biến thể
        foreach ($products as $productData) {
            $product = Product::create([
                'name' => $productData['name'],
                'description' => $productData['description'],
                'brand_id' => $brands[$productData['brand']]->id,
                'category_id' => $categories[$productData['category']]->id,
                'origin_id' => $origins[$productData['origin']]->id,
            ]);

            foreach ($productData['variants'] as $variantData) {
                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'sku' => $variantData['sku'],
                    'price' => $variantData['price'],
                    'quantity' => $variantData['quantity'],
                    'status' => 'active',
                ]);

                // Tạo thuộc tính cho biến thể
                foreach ($variantData['attributes'] as $attrName => $attrValue) {
                    if (isset($attributeValues[$attrName][$attrValue])) {
                        VariantAttributeValue::create([
                            'product_variant_id' => $variant->id,
                            'attribute_id' => $attributes[$attrName]->id,
                            'attribute_value_id' => $attributeValues[$attrName][$attrValue]->id,
                        ]);
                    }
                }
            }
        }
    }
} 