<?php

namespace App\Http\Requests\v1\post;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{

    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required',
            'tags' => 'required|array',
            'categories' => 'required|array',
            'image' => 'nullable|mime',
        ];
    }
}