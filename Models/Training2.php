<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training2 extends Model
{
    use HasFactory;
    protected $table = 'training2s';
    protected $fillable = [
        'id',
        'trainer_id',
        'employees_id',
        'training_type',
        'trainer',
        'obstacle_faced',
        'today_task',
        'start_date',
        'summary',
        'status',
    ];
}
