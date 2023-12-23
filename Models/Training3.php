<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training3 extends Model
{
    use HasFactory;
    protected $table = 'training3s';
    protected $fillable = [
        'id',
        'trainer_id',
        'employees_id',
        'training_type',
        'trainer',
        'today_task',
        'start_date',
        'status',
    ];
}
