<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function user(): BelongsToMany
    {
        return $this->belongsTo(User::class);
    }

}
