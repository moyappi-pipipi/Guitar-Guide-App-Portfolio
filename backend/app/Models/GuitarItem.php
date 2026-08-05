<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuitarItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'brand',
        'category',
        'price',
        'specs',
        'description',
        'image_url',
        'is_recommended',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_recommended' => 'boolean',
        ];
    }
}
