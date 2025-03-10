<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded=[];
    
    // Hidden original fields to avoid showing them in API responses
    protected $hidden = ['name_en', 'name_ar', 'description_en', 'description_ar'];

    // Append dynamically calculated attributes
    protected $appends = ['name', 'description'];

    public function getNameAttribute()
    {
        $locale = app()->getLocale();
        $attribute = "name_{$locale}";
        return $this->{$attribute};
    }


    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $attribute = "description_{$locale}";

        return $this->{$attribute};
    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($product) {
            $product->cardPackages()->detach();
        });
    }

    public function productImages()
    {
        return $this->hasMany(ProductPhoto::class);
    }


    public function category()
    {
        return $this->belongsTo(Category::class,);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class,);
    }

    public function cardPackages()
    {
        return $this->belongsToMany(CardPackage::class, 'card_package_products')
                    ->withPivot('selling_price')
                    ->withTimestamps();
    }

    public function cardPackageProducts()
    {
        return $this->hasMany(CardPackageProduct::class);
    }
    public function voucherProducts()
    {
        return $this->hasMany(VoucherProduct::class);
    }

    public function offers()
    {
        return $this->hasMany(Offer::class)->whereDate('expired_at', '>', now());
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_products')->withPivot('variation_id','quantity','unit_price','total_price_after_tax','tax_percentage','tax_value','total_price_before_tax','discount_percentage','discount_value');
    }
}
