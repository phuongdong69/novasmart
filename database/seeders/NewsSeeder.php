<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Lấy user đầu tiên làm tác giả
        $author = User::first();

        if (!$author) {
            $this->command->error('Không tìm thấy user nào. Vui lòng chạy UserSeeder trước.');
            return;
        }

        // Dữ liệu mẫu cho tin tức
        $newsData = [
            [
                'title' => 'Công nghệ AI đang thay đổi thế giới',
                'excerpt' => 'Trí tuệ nhân tạo đang tạo ra những bước tiến vượt bậc trong nhiều lĩnh vực...',
                'content' => 'Trí tuệ nhân tạo (AI) đang tạo ra những bước tiến vượt bậc trong nhiều lĩnh vực từ y tế, giáo dục đến thương mại. Các công nghệ như machine learning, deep learning đang được ứng dụng rộng rãi và mang lại hiệu quả cao.',
                'category_name' => 'Công nghệ',
                'category_slug' => 'cong-nghe',
                'tags' => ['AI', 'Machine Learning', 'Công nghệ'],
                'featured_image' => '/images/news/ai-tech.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views' => 1250,
                'likes' => 89
            ],
            [
                'title' => 'Xu hướng thương mại điện tử 2024',
                'excerpt' => 'Thương mại điện tử tiếp tục phát triển mạnh mẽ với những xu hướng mới...',
                'content' => 'Năm 2024 chứng kiến sự phát triển mạnh mẽ của thương mại điện tử với những xu hướng mới như mua sắm qua mạng xã hội, thanh toán kỹ thuật số và trải nghiệm mua sắm cá nhân hóa.',
                'category_name' => 'Thương mại',
                'category_slug' => 'thuong-mai',
                'tags' => ['E-commerce', 'Thương mại điện tử', 'Xu hướng'],
                'featured_image' => '/images/news/ecommerce.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views' => 980,
                'likes' => 67
            ],
            [
                'title' => 'Bảo mật thông tin trong thời đại số',
                'excerpt' => 'Vấn đề bảo mật thông tin ngày càng trở nên quan trọng...',
                'content' => 'Trong thời đại số, bảo mật thông tin trở thành vấn đề quan trọng hàng đầu. Các doanh nghiệp và cá nhân cần áp dụng các biện pháp bảo mật hiện đại để bảo vệ dữ liệu.',
                'category_name' => 'Bảo mật',
                'category_slug' => 'bao-mat',
                'tags' => ['Bảo mật', 'Thông tin', 'An toàn'],
                'featured_image' => '/images/news/security.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views' => 756,
                'likes' => 45
            ],
            [
                'title' => 'Phát triển ứng dụng di động với Flutter',
                'excerpt' => 'Flutter đang trở thành framework phát triển ứng dụng di động phổ biến...',
                'content' => 'Flutter của Google đang trở thành framework phát triển ứng dụng di động phổ biến nhờ khả năng cross-platform và hiệu suất cao. Nhiều startup và doanh nghiệp lớn đã chuyển sang sử dụng Flutter.',
                'category_name' => 'Lập trình',
                'category_slug' => 'lap-trinh',
                'tags' => ['Flutter', 'Mobile App', 'Lập trình'],
                'featured_image' => '/images/news/flutter.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views' => 634,
                'likes' => 38
            ],
            [
                'title' => 'Tương lai của blockchain và tiền điện tử',
                'excerpt' => 'Blockchain tiếp tục phát triển với nhiều ứng dụng mới...',
                'content' => 'Blockchain không chỉ là nền tảng cho tiền điện tử mà còn mở ra nhiều ứng dụng mới trong các lĩnh vực như tài chính, y tế, giáo dục và chuỗi cung ứng.',
                'category_name' => 'Blockchain',
                'category_slug' => 'blockchain',
                'tags' => ['Blockchain', 'Cryptocurrency', 'Công nghệ'],
                'featured_image' => '/images/news/blockchain.jpg',
                'status' => 'published',
                'is_featured' => true,
                'views' => 892,
                'likes' => 56
            ],
            [
                'title' => 'Cloud Computing và tương lai của doanh nghiệp',
                'excerpt' => 'Điện toán đám mây đang thay đổi cách doanh nghiệp vận hành...',
                'content' => 'Cloud computing đang thay đổi cách doanh nghiệp vận hành và quản lý dữ liệu. Các dịch vụ cloud như AWS, Azure, Google Cloud đang trở thành nền tảng quan trọng cho sự phát triển của doanh nghiệp.',
                'category_name' => 'Cloud',
                'category_slug' => 'cloud',
                'tags' => ['Cloud Computing', 'AWS', 'Azure'],
                'featured_image' => '/images/news/cloud.jpg',
                'status' => 'published',
                'is_featured' => false,
                'views' => 567,
                'likes' => 34
            ]
        ];

        foreach ($newsData as $data) {
            $data['slug'] = Str::slug($data['title']);
            $data['user_id'] = $author->id;
            $data['published_at'] = now()->subDays(rand(1, 30));
            
            News::create($data);
        }

        $this->command->info('Đã tạo ' . count($newsData) . ' bài viết tin tức mẫu.');
    }
} 