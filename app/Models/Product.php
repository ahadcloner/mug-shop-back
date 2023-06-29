<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden =['created_at' , 'updated_at','product_category_id' ,'product_group_id','product_type_id'];

    public function tags()
    {
        return $this->hasMany(ProductTag::class);
    }
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
    public function brand()
    {
        return $this->hasOne(ProductBrand::class);
    }
    public function category()
    {
        return $this->belongsTo(ProductCategory::class ,'product_category_id','id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }


}
