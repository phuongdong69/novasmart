<?php

namespace App\Helpers;

use App\Models\Status;
use Illuminate\Support\Collection;

class StatusHelper
{
    /**
     * Get all statuses ordered by type and priority
     */
    public static function getAllStatuses(): Collection
    {
        return Status::orderBy('type')
                    ->orderBy('priority')
                    ->get();
    }

    /**
     * Get statuses by type
     */
    public static function getStatusesByType(string $type): Collection
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->get();
    }

    /**
     * Get status by code and type
     */
    public static function getStatusByCodeAndType(string $code, string $type): ?Status
    {
        return Status::where('code', $code)
                    ->where('type', $type)
                    ->first();
    }

    /**
     * Get status options for select dropdown
     */
    public static function getStatusOptionsByType(string $type): array
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->pluck('name', 'code')
                    ->toArray();
    }

    /**
     * Get status options with ID as key
     */
    public static function getStatusOptionsWithIdByType(string $type): array
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->pluck('name', 'id')
                    ->toArray();
    }

    /**
     * Get next status in sequence
     */
    public static function getNextStatus(Status $currentStatus): ?Status
    {
        return Status::where('type', $currentStatus->type)
                    ->where('priority', '>', $currentStatus->priority)
                    ->orderBy('priority')
                    ->first();
    }

    /**
     * Get previous status in sequence
     */
    public static function getPreviousStatus(Status $currentStatus): ?Status
    {
        return Status::where('type', $currentStatus->type)
                    ->where('priority', '<', $currentStatus->priority)
                    ->orderBy('priority', 'desc')
                    ->first();
    }

    /**
     * Get first status by type
     */
    public static function getFirstStatusByType(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->first();
    }

    /**
     * Get last status by type
     */
    public static function getLastStatusByType(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority', 'desc')
                    ->first();
    }

    /**
     * Check if status is the first in sequence
     */
    public static function isFirstStatus(Status $status): bool
    {
        $firstStatus = self::getFirstStatusByType($status->type);
        return $firstStatus && $firstStatus->id === $status->id;
    }

    /**
     * Check if status is the last in sequence
     */
    public static function isLastStatus(Status $status): bool
    {
        $lastStatus = self::getLastStatusByType($status->type);
        return $lastStatus && $lastStatus->id === $status->id;
    }

    /**
     * Get status display with color
     */
    public static function getStatusDisplay(Status $status): string
    {
        return '<span class="px-2 py-1 text-xs rounded" style="background:' . ($status->color ?: '#eee') . ';color:#222;" title="' . e($status->description) . '">' . e($status->name) . '</span>';
    }

    /**
     * Get status types
     */
    public static function getStatusTypes(): array
    {
        return Status::distinct()
                    ->pluck('type')
                    ->toArray();
    }

    /**
     * Update model status
     */
    public static function updateModelStatus($model, string $statusCode, string $type, $userId = null, $note = null): bool
    {
        $status = self::getStatusByCodeAndType($statusCode, $type);
        
        if (!$status) {
            return false;
        }

        // Update status_id and status_code
        $model->status_id = $status->id;
        $model->status_code = $statusCode;
        $model->save();

        // Log if model has statusLogs method
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
     * Get status display info
     */
    public static function getStatusDisplayInfo(string $code, string $type): ?array
    {
        $status = self::getStatusByCodeAndType($code, $type);
        if (!$status) {
            return null;
        }

            return [
            'id' => $status->id,
            'name' => $status->name,
                'code' => $status->code,
                'color' => $status->color,
            'priority' => $status->priority,
            'description' => $status->description,
            'display' => self::getStatusDisplay($status)
        ];
    }

    /**
     * Check if status is valid
     */
    public static function isValidStatus(string $code, string $type): bool
    {
        $status = self::getStatusByCodeAndType($code, $type);
        return $status && $status->is_active;
    }

    /**
     * Get default status for type
     */
    public static function getDefaultStatus(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->first();
    }

    /**
     * Get available types
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
     * Create new status
     */
    public static function createStatus(array $data): Status
    {
        return Status::create($data);
    }

    /**
     * Update status
     */
    public static function updateStatus(Status $status, array $data): bool
    {
        return $status->update($data);
    }

    /**
     * Delete status (soft delete)
     */
    public static function deleteStatus(Status $status): bool
    {
        return $status->update(['is_active' => false]);
    }

    /**
     * Get status workflow
     */
    public static function getStatusWorkflow(string $type): Collection
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->get();
    }
} 