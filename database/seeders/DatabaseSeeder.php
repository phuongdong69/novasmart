<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1) Cơ sở
            StatusSeeder::class,
            RoleSeeder::class,
            AuthorSeeder::class,

            // 2) Danh mục nền tảng
            CategorySeeder::class,
            OriginSeeder::class,
            BrandSeeder::class,
            AttributeSeeder::class,
            AttributeValueSeeder::class,
            CategoryAttributeSeeder::class,

            // 3) Sản phẩm và biến thể
            ProductSeeder::class,
            ProductVariantSeeder::class,

            // 4) Khuyến mãi, đơn hàng và liên quan
            VoucherSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,

            // 5) Nội dung
            CommentSeeder::class,
            // SlideshowSeeder::class,
            // MenuDataSeeder::class,
        ]);
    }
}
