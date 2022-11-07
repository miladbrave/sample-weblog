<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'path', 'name', 'original_name', 'size', 'user_id', 'mime', 'disk'
    ];

    public function answer()
    {
        return $this->morphTo('fileable');
    }
}
