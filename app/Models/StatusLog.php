<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusLog extends Model
{
    protected $fillable = [
        'loggable_type', 'loggable_id', 'status_id', 'user_id', 'note'
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function loggable()
    {
        return $this->morphTo();
    }
} 