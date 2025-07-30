<?php

namespace App\Services;

use App\Models\Status;
use Illuminate\Support\Collection;

class StatusService
{
    /**
     * Lấy tất cả status theo type
     */
    public static function getStatusesByType(string $type): Collection
    {
        return Status::getByType($type);
    }

    /**
     * Lấy status theo code và type
     */
    public static function getStatusByCode(string $code, string $type): ?Status
    {
        return Status::findByCodeAndType($code, $type);
    }

    /**
     * Lấy options cho select dropdown
     */
    public static function getStatusOptions(string $type): array
    {
        return Status::getOptionsByType($type);
    }

    /**
     * Cập nhật status cho model
     */
    public static function updateModelStatus($model, string $statusCode, string $type, $userId = null, $note = null): bool
    {
        $status = self::getStatusByCode($statusCode, $type);
        
        if (!$status) {
            return false;
        }

        // Cập nhật status_id và status_code
        $model->status_id = $status->id;
        $model->status_code = $statusCode;
        $model->save();

        // Ghi log nếu model có method statusLogs
        if (method_exists($model, 'statusLogs')) {
            $model->statusLogs()->create([
                'status_id' => $status->id,
                'user_id' => $userId,
                'note' => $note,
            ]);
        }

        return true;
    }

    /**
     * Lấy display info của status
     */
    public static function getStatusDisplay(string $code, string $type): ?array
    {
        $status = self::getStatusByCode($code, $type);
        return $status ? $status->display : null;
    }

    /**
     * Kiểm tra status có hợp lệ không
     */
    public static function isValidStatus(string $code, string $type): bool
    {
        $status = self::getStatusByCode($code, $type);
        return $status && $status->is_active;
    }

    /**
     * Lấy status mặc định cho type
     */
    public static function getDefaultStatus(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->first();
    }

    /**
     * Lấy tất cả types có sẵn
     */
    public static function getAvailableTypes(): array
    {
        return Status::distinct()
                    ->pluck('type')
                    ->filter()
                    ->values()
                    ->toArray();
    }

    /**
     * Tạo status mới
     */
    public static function createStatus(array $data): Status
    {
        return Status::create($data);
    }

    /**
     * Cập nhật status
     */
    public static function updateStatus(Status $status, array $data): bool
    {
        return $status->update($data);
    }

    /**
     * Xóa status (soft delete)
     */
    public static function deleteStatus(Status $status): bool
    {
        return $status->update(['is_active' => false]);
    }

    /**
     * Lấy status theo thứ tự workflow
     */
    public static function getStatusWorkflow(string $type): Collection
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('sort_order')
                    ->get();
    }

    /**
     * Lấy next status trong workflow
     */
    public static function getNextStatus(string $currentCode, string $type): ?Status
    {
        $currentStatus = self::getStatusByCode($currentCode, $type);
        if (!$currentStatus) {
            return null;
        }

        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->where('sort_order', '>', $currentStatus->sort_order)
                    ->orderBy('sort_order')
                    ->first();
    }

    /**
     * Lấy previous status trong workflow
     */
    public static function getPreviousStatus(string $currentCode, string $type): ?Status
    {
        $currentStatus = self::getStatusByCode($currentCode, $type);
        if (!$currentStatus) {
            return null;
        }

        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->where('sort_order', '<', $currentStatus->sort_order)
                    ->orderBy('sort_order', 'desc')
                    ->first();
    }
} 