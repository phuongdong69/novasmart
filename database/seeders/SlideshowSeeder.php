<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Slideshow;

class SlideshowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $slideshows = [
            [
                'title' => 'Khuyến Mãi Mùa Hè',
                'description' => 'Giảm giá lên đến 50% cho tất cả sản phẩm mùa hè',
                'image' => 'slideshows/slide1.jpg',
                'link' => '#',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Bộ Sưu Tập Mới',
                'description' => 'Khám phá bộ sưu tập mới nhất với thiết kế độc đáo',
                'image' => 'slideshows/slide2.jpg',
                'link' => '#',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Miễn Phí Vận Chuyển',
                'description' => 'Miễn phí vận chuyển cho đơn hàng từ 500k',
                'image' => 'slideshows/slide3.jpg',
                'link' => '#',
                'order' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($slideshows as $slideshow) {
            Slideshow::create($slideshow);
        }
    }
} 