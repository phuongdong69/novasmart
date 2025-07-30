<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Kiểm tra xem constraint đã tồn tại chưa
        $indexes = DB::select("SHOW INDEX FROM statuses WHERE Key_name = 'statuses_code_type_unique'");
        if (empty($indexes)) {
            Schema::table('statuses', function (Blueprint $table) {
                // Thêm unique constraint cho code và type
                $table->unique(['code', 'type'], 'statuses_code_type_unique');
            });
        }

        // Cập nhật dữ liệu cho voucher statuses - kiểm tra trước khi update
        $activeVoucher = DB::table('statuses')
            ->where('type', 'voucher')
            ->where('name', 'Hoạt động')
            ->first();
            
        if ($activeVoucher && !$activeVoucher->code) {
            DB::table('statuses')
                ->where('id', $activeVoucher->id)
                ->update([
                    'code' => 'active',
                    'sort_order' => 1
                ]);
        }

        $inactiveVoucher = DB::table('statuses')
            ->where('type', 'voucher')
            ->where('name', 'Ngừng hoạt động')
            ->first();
            
        if ($inactiveVoucher && !$inactiveVoucher->code) {
            DB::table('statuses')
                ->where('id', $inactiveVoucher->id)
                ->update([
                    'code' => 'inactive',
                    'sort_order' => 2
                ]);
        }

        // Thêm các status mới cho voucher - kiểm tra trước khi insert
        $existingExpired = DB::table('statuses')
            ->where('code', 'expired')
            ->where('type', 'voucher')
            ->first();
            
        if (!$existingExpired) {
            DB::table('statuses')->insert([
                'code' => 'expired',
                'name' => 'Hết hạn',
                'type' => 'voucher',
                'color' => '#e3342f',
                'sort_order' => 3,
                'is_active' => true,
                'description' => 'Voucher đã hết hạn',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $existingDraft = DB::table('statuses')
            ->where('code', 'draft')
            ->where('type', 'voucher')
            ->first();
            
        if (!$existingDraft) {
            DB::table('statuses')->insert([
                'code' => 'draft',
                'name' => 'Bản nháp',
                'type' => 'voucher',
                'color' => '#6c757d',
                'sort_order' => 0,
                'is_active' => true,
                'description' => 'Voucher chưa được kích hoạt',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Thêm status cho product - kiểm tra trước khi insert
        $existingProductDraft = DB::table('statuses')
            ->where('code', 'draft')
            ->where('type', 'product')
            ->first();
            
        if (!$existingProductDraft) {
            DB::table('statuses')->insert([
                'code' => 'draft',
                'name' => 'Bản nháp',
                'type' => 'product',
                'color' => '#6c757d',
                'sort_order' => 0,
                'is_active' => true,
                'description' => 'Sản phẩm chưa được xuất bản',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $existingProductPublished = DB::table('statuses')
            ->where('code', 'published')
            ->where('type', 'product')
            ->first();
            
        if (!$existingProductPublished) {
            DB::table('statuses')->insert([
                'code' => 'published',
                'name' => 'Đã xuất bản',
                'type' => 'product',
                'color' => '#3490dc',
                'sort_order' => 1,
                'is_active' => true,
                'description' => 'Sản phẩm đã được xuất bản',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('statuses', function (Blueprint $table) {
            // Xóa unique constraint
            $table->dropUnique('statuses_code_type_unique');
        });

        // Xóa các status đã thêm
        DB::table('statuses')
            ->whereIn('code', ['expired', 'draft'])
            ->where('type', 'voucher')
            ->delete();

        DB::table('statuses')
            ->whereIn('code', ['draft', 'published'])
            ->where('type', 'product')
            ->delete();
    }
};
