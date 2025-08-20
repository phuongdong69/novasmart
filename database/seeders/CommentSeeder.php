<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        // texts mẫu
        $texts = [
            'Sản phẩm rất tốt, đáng mua.',
            'Giao hàng nhanh, đóng gói kỹ.',
            'Chất lượng ổn trong tầm giá.',
            'Hơi nóng khi chơi game nặng.',
        ];

        // status cho comment (fallback 1 nếu chưa có)
        $statusId = DB::table('statuses')
            ->where('type', 'comment')
            ->where('code', 'active')
            ->value('id') ?: 1;

        // Lấy danh sách order_details kèm order (để lấy user_id)
        $details = DB::table('order_details as od')
            ->join('orders as o', 'o.id', '=', 'od.order_id')
            ->select([
                'od.id as order_detail_id',
                'od.order_id',
                'od.product_variant_id',
                'o.user_id',
            ])->get();

        if ($details->isEmpty()) {
            $this->command->warn('⚠️ Chưa có order_details. Hãy seed orders và order_details trước.');
            return;
        }

        foreach ($details as $d) {
            // Nếu bảng của bạn unique theo chỉ order_detail_id
            $exists = DB::table('comments')
                ->where('order_detail_id', $d->order_detail_id)
                // Nếu unique theo (user_id, order_detail_id) thì thêm điều kiện dưới đây
                ->where('user_id', $d->user_id)
                ->exists();

            if ($exists) continue;

            DB::table('comments')->insert([
                'user_id'            => $d->user_id,
                'status_id'          => $statusId,
                'product_variant_id' => $d->product_variant_id,
                'order_id'           => $d->order_id,
                'order_detail_id'    => $d->order_detail_id,
                'content'            => $texts[array_rand($texts)],
                'created_at'         => $now,
                'updated_at'         => $now,
            ]);
        }

        $this->command->info('✅ Seed comments: xong, mỗi order_detail tối đa 1 bình luận.');
    }
}
