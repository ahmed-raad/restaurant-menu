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
        'image_url',
        'image_id',
        'image_name',
        'description',
        'price',
        'is_available',
    ];

    public function getImagePathAttribute()
    {
        return asset('https://drive.google.com/uc?id='.$this->image_id);
    }
}
