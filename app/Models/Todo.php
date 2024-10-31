<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    const PENDING = 0;

    const COMPLETED = 1;

    const STATUSES = [
        self::PENDING => 'Pending',
        self::COMPLETED => 'Completed',
    ];
}
