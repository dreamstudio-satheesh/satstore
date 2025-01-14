<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_tamil',
        'name_english',
        'category_id',
        'hsn_code',
        'price',
        'gst_slab',
        'barcode',
    ];
}
