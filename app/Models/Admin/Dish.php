<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    use HasFactory;

    protected $table = 'dishes';

    protected $fillable = [
        'name',
        'category',
        'sub_category',
        'image',
        'description',
        'price',
        'is_available',
    ];
}
