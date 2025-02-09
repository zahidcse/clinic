<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductPriceVariation extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'product_price_variations';

    public static function productVariationInfo($id)
    {
        return ProductPriceVariation::where('id', $id)->first();
    }
}
