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
        RoleSeeder::class,
        AuthorSeeder::class,
        CategorySeeder::class,
        OriginSeeder::class,
        CategorySeeder::class,
        // ProductThumbnailSeeder::class,
        StatusSeeder::class,
    ]);

        // Đồng bộ status_id cho user dựa vào status_code và type='user'
        foreach (['active', 'locked', 'suspended', 'pending_verification'] as $code) {
            $status = \App\Models\Status::where('type', 'user')->where('code', $code)->first();
            if ($status) {
                \App\Models\User::where('status_code', $code)->update(['status_id' => $status->id]);
            }
        }

        // Sửa status_id cho user về đúng id của status 'active' type 'user'
        $activeStatus = \App\Models\Status::where('type', 'user')->where('code', 'active')->first();
        if ($activeStatus) {
            \App\Models\User::where('status_id', 1)->update(['status_id' => $activeStatus->id]);
        }

        // Fix: cập nhật created_at cho user bị thiếu
        \App\Models\User::whereNull('created_at')->update(['created_at' => now()]);
        \App\Models\User::where('created_at', '')->update(['created_at' => now()]);
    }
}
