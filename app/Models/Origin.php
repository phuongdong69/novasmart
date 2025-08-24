<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Origin extends Model
{
    protected $fillable = ['country', 'status_id'];
    use HasFactory;

    public function status()
{
    return $this->belongsTo(\App\Models\Status::class, 'status_id');
}
}
