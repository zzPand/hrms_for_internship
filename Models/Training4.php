<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training4 extends Model
{
    use HasFactory;

    protected $table = 'training4s';

    protected $fillable = [
        'id',
        'trainer_id',
        'employees_id',
        'students',
        'training_type',
        'trainer',
        'today_tasks', // Updated field name
        'conclusion',
        'status',
    ];

    protected $casts = [
        'today_tasks' => 'json',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
