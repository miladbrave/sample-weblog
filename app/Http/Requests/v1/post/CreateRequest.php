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
            'category' => 'required|numeric',
            'image' => 'nullable|mimes:jpg,bmp,png,jpeg',
        ];
    }
}
