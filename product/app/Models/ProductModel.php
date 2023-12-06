<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends Model
{
    use HasFactory,SoftDeletes;
    protected $table ="products";
    protected $fillable = [
        'product_name',
        'product_image',
        'gia_ban',
        'mo_ta',
        'ngay_tao',
        'ngay_Cap_nhat'
    ];
}
