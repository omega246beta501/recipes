<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MercadonaProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'url',
        'image_path',
    ];
}
