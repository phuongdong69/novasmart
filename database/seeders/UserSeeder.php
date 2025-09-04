<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Tạo users với timestamps từ 1/8/2025 đến 15/8/2025
        $startDate = Carbon::create(2025, 8, 1, 0, 0, 0);
        $endDate = Carbon::create(2025, 8, 15, 23, 59, 59);
        
        $users = [
            [
                'name' => 'Nguyễn Văn An',
                'email' => 'nguyenvanan@gmail.com',
                'phone' => '0901234567',
                'address' => '123 Nguyễn Trãi, Quận 1, TP.HCM',
            ],
            [
                'name' => 'Trần Thị Bình',
                'email' => 'tranthibinh@gmail.com',
                'phone' => '0912345678',
                'address' => '456 Lê Lợi, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Lê Hoàng Cường',
                'email' => 'lehoangcuong@gmail.com',
                'phone' => '0923456789',
                'address' => '789 Trần Hưng Đạo, Quận 5, TP.HCM',
            ],
            [
                'name' => 'Phạm Thị Dung',
                'email' => 'phamthidung@gmail.com',
                'phone' => '0934567890',
                'address' => '321 Hai Bà Trưng, Quận Bình Thạnh, TP.HCM',
            ],
            [
                'name' => 'Võ Văn Em',
                'email' => 'vovanem@gmail.com',
                'phone' => '0945678901',
                'address' => '654 Điện Biên Phủ, Quận 10, TP.HCM',
            ],
            [
                'name' => 'Đỗ Thị Phương',
                'email' => 'dothiphuong@gmail.com',
                'phone' => '0956789012',
                'address' => '987 Lý Thường Kiệt, Quận Tân Bình, TP.HCM',
            ],
            [
                'name' => 'Hoàng Văn Giang',
                'email' => 'hoangvangiang@gmail.com',
                'phone' => '0967890123',
                'address' => '147 Nguyễn Huệ, Quận 1, TP.HCM',
            ],
            [
                'name' => 'Ngô Thị Hoa',
                'email' => 'ngothihoa@gmail.com',
                'phone' => '0978901234',
                'address' => '258 Lê Duẩn, Quận 1, TP.HCM',
            ],
            [
                'name' => 'Bùi Văn Inh',
                'email' => 'buivaninh@gmail.com',
                'phone' => '0989012345',
                'address' => '369 Võ Văn Kiệt, Quận 5, TP.HCM',
            ],
            [
                'name' => 'Lý Thị Kim',
                'email' => 'lythikim@gmail.com',
                'phone' => '0990123456',
                'address' => '741 Cách Mạng Tháng 8, Quận 10, TP.HCM',
            ],
            [
                'name' => 'Trương Văn Long',
                'email' => 'truongvanlong@gmail.com',
                'phone' => '0901234568',
                'address' => '852 Pasteur, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Đinh Thị Mai',
                'email' => 'dinhthimai@gmail.com',
                'phone' => '0912345679',
                'address' => '963 Nam Kỳ Khởi Nghĩa, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Vũ Văn Nam',
                'email' => 'vuvannam@gmail.com',
                'phone' => '0923456780',
                'address' => '159 Nguyễn Thị Minh Khai, Quận 1, TP.HCM',
            ],
            [
                'name' => 'Cao Thị Oanh',
                'email' => 'caothioanh@gmail.com',
                'phone' => '0934567891',
                'address' => '357 Lê Văn Sỹ, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Đặng Văn Phúc',
                'email' => 'dangvanphuc@gmail.com',
                'phone' => '0945678902',
                'address' => '468 Hoàng Văn Thụ, Quận Phú Nhuận, TP.HCM',
            ],
            [
                'name' => 'Nguyễn Thị Quỳnh',
                'email' => 'nguyenthiquynh@gmail.com',
                'phone' => '0956789013',
                'address' => '579 Phan Xích Long, Quận Phú Nhuận, TP.HCM',
            ],
            [
                'name' => 'Lê Văn Rồng',
                'email' => 'levanrong@gmail.com',
                'phone' => '0967890124',
                'address' => '680 Nguyễn Đình Chiểu, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Phạm Thị Sương',
                'email' => 'phamthisuong@gmail.com',
                'phone' => '0978901235',
                'address' => '791 Võ Thị Sáu, Quận 3, TP.HCM',
            ],
            [
                'name' => 'Trần Văn Tài',
                'email' => 'tranvantai@gmail.com',
                'phone' => '0989012346',
                'address' => '802 Nguyễn Công Trứ, Quận 1, TP.HCM',
            ],
            [
                'name' => 'Võ Thị Uyên',
                'email' => 'vothiuyen@gmail.com',
                'phone' => '0990123457',
                'address' => '913 Ký Con, Quận 1, TP.HCM',
            ]
        ];

        foreach ($users as $index => $userData) {
            // Phân bố users đều trong khoảng thời gian
            $daysRange = $endDate->diffInDays($startDate) + 1; // 15 ngày
            $dayOffset = ($index % $daysRange);
            $userDate = $startDate->copy()->addDays($dayOffset)->addHours(rand(8, 20))->addMinutes(rand(0, 59));
            
            User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'email_verified_at' => $userDate->copy()->addMinutes(rand(5, 60)),
                'password' => Hash::make('password123'), // Default password
                'phone' => $userData['phone'],
                'address' => $userData['address'],
                'created_at' => $userDate,
                'updated_at' => $userDate,
            ]);
        }

        $this->command->info('Đã tạo thành công ' . count($users) . ' users từ 1/8/2025 đến 15/8/2025');
    }
}
