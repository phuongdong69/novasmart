<?php

namespace App\Services;

use App\Models\Status;
use Illuminate\Support\Collection;

class StatusService
{
    /**
     * Get all statuses ordered by type and priority
     */
    public function getAllStatuses(): Collection
    {
        return Status::orderBy('type')
                    ->orderBy('priority')
                    ->get();
    }

    /**
     * Get statuses by type
     */
    public function getStatusesByType(string $type): Collection
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->get();
    }

    /**
     * Get status by code and type
     */
    public function getStatusByCodeAndType(string $code, string $type): ?Status
    {
        return Status::where('code', $code)
                    ->where('type', $type)
                    ->first();
    }

    /**
     * Get status options for select dropdown
     */
    public function getStatusOptionsByType(string $type): array
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
    public function getStatusOptionsWithIdByType(string $type): array
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
    public function getNextStatus(Status $currentStatus): ?Status
    {
        return Status::where('type', $currentStatus->type)
                    ->where('priority', '>', $currentStatus->priority)
                    ->orderBy('priority')
                    ->first();
    }

    /**
     * Get previous status in sequence
     */
    public function getPreviousStatus(Status $currentStatus): ?Status
    {
        return Status::where('type', $currentStatus->type)
                    ->where('priority', '<', $currentStatus->priority)
                    ->orderBy('priority', 'desc')
                    ->first();
    }

    /**
     * Get first status by type
     */
    public function getFirstStatusByType(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority')
                    ->first();
    }

    /**
     * Get last status by type
     */
    public function getLastStatusByType(string $type): ?Status
    {
        return Status::where('type', $type)
                    ->where('is_active', true)
                    ->orderBy('priority', 'desc')
                    ->first();
    }

    /**
     * Check if status is the first in sequence
     */
    public function isFirstStatus(Status $status): bool
    {
        $firstStatus = $this->getFirstStatusByType($status->type);
        return $firstStatus && $firstStatus->id === $status->id;
    }

    /**
     * Check if status is the last in sequence
     */
    public function isLastStatus(Status $status): bool
    {
        $lastStatus = $this->getLastStatusByType($status->type);
        return $lastStatus && $lastStatus->id === $status->id;
    }

    /**
     * Get status display with color
     */
    public function getStatusDisplay(Status $status): string
    {
        return '<span class="px-2 py-1 text-xs rounded" style="background:' . ($status->color ?: '#eee') . ';color:#222;" title="' . e($status->description) . '">' . e($status->name) . '</span>';
    }

    /**
     * Get status types
     */
    public function getStatusTypes(): array
    {
        return Status::distinct()
                    ->pluck('type')
                    ->toArray();
    }
} 