<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:255',
            'completed' => 'boolean',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
            'category_id' => 'nullable|exists:categories,id',
        ];
    }
}
