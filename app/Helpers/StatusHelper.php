<?php

namespace App\Helpers;

use App\Models\Status;
use App\Services\StatusService;

class StatusHelper
{
    /**
     * Hiển thị status badge với màu sắc
     */
    public static function displayStatusBadge($statusCode, $type, $showIcon = false): string
    {
        $status = StatusService::getStatusByCode($statusCode, $type);
        
        if (!$status) {
            return '<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800">N/A</span>';
        }

        $icon = $showIcon ? self::getStatusIcon($statusCode, $type) : '';
        
        return sprintf(
            '<span class="px-2 py-1 text-xs rounded" style="background-color: %s; color: white;">%s %s</span>',
            $status->color,
            $icon,
            $status->name
        );
    }

    /**
     * Hiển thị status text đơn giản
     */
    public static function displayStatusText($statusCode, $type): string
    {
        $status = StatusService::getStatusByCode($statusCode, $type);
        return $status ? $status->name : 'N/A';
    }

    /**
     * Lấy icon cho status
     */
    public static function getStatusIcon($statusCode, $type): string
    {
        $icons = [
            'order' => [
                'pending' => '⏳',
                'processing' => '⚙️',
                'shipped' => '🚚',
                'completed' => '✅',
                'cancelled' => '❌',
            ],
            'user' => [
                'active' => '✅',
                'suspended' => '🔒',
                'pending_verification' => '📧',
            ],
            'product' => [
                'draft' => '📝',
                'published' => '📢',
                'in_stock' => '📦',
                'out_of_stock' => '🚫',
            ],
            'voucher' => [
                'draft' => '📝',
                'active' => '✅',
                'inactive' => '⏸️',
                'expired' => '⏰',
            ],
        ];

        return $icons[$type][$statusCode] ?? '';
    }

    /**
     * Lấy CSS class cho status
     */
    public static function getStatusClass($statusCode, $type): string
    {
        $status = StatusService::getStatusByCode($statusCode, $type);
        
        if (!$status) {
            return 'bg-gray-100 text-gray-800';
        }

        // Chuyển đổi màu hex sang Tailwind classes
        $colorMap = [
            '#38c172' => 'bg-green-100 text-green-800',
            '#e3342f' => 'bg-red-100 text-red-800',
            '#f59e42' => 'bg-yellow-100 text-yellow-800',
            '#3490dc' => 'bg-blue-100 text-blue-800',
            '#6c757d' => 'bg-gray-100 text-gray-800',
        ];

        return $colorMap[$status->color] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Lấy options cho select dropdown
     */
    public static function getStatusOptions($type): array
    {
        return StatusService::getStatusOptions($type);
    }

    /**
     * Kiểm tra status có hợp lệ không
     */
    public static function isValidStatus($statusCode, $type): bool
    {
        return StatusService::isValidStatus($statusCode, $type);
    }

    /**
     * Lấy status mặc định cho type
     */
    public static function getDefaultStatus($type): ?Status
    {
        return StatusService::getDefaultStatus($type);
    }

    /**
     * Hiển thị status với tooltip
     */
    public static function displayStatusWithTooltip($statusCode, $type): string
    {
        $status = StatusService::getStatusByCode($statusCode, $type);
        
        if (!$status) {
            return '<span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-800" title="Không xác định">N/A</span>';
        }

        return sprintf(
            '<span class="px-2 py-1 text-xs rounded cursor-help" style="background-color: %s; color: white;" title="%s">%s</span>',
            $status->color,
            $status->description,
            $status->name
        );
    }

    /**
     * Lấy workflow cho type
     */
    public static function getWorkflow($type): array
    {
        $workflow = StatusService::getStatusWorkflow($type);
        return $workflow->map(function ($status) {
            return [
                'code' => $status->code,
                'name' => $status->name,
                'color' => $status->color,
                'sort_order' => $status->sort_order,
            ];
        })->toArray();
    }

    /**
     * Lấy next status trong workflow
     */
    public static function getNextStatus($currentCode, $type): ?array
    {
        $nextStatus = StatusService::getNextStatus($currentCode, $type);
        return $nextStatus ? [
            'code' => $nextStatus->code,
            'name' => $nextStatus->name,
            'color' => $nextStatus->color,
        ] : null;
    }

    /**
     * Lấy previous status trong workflow
     */
    public static function getPreviousStatus($currentCode, $type): ?array
    {
        $prevStatus = StatusService::getPreviousStatus($currentCode, $type);
        return $prevStatus ? [
            'code' => $prevStatus->code,
            'name' => $prevStatus->name,
            'color' => $prevStatus->color,
        ] : null;
    }
} 