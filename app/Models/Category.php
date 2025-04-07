<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $hidden = [
        'updated_at',
        'created_at',
        'pivot',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
