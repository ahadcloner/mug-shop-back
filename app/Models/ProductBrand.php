<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductBrand extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=['created_at' , 'updated_at','product_id','brand_id' ,'id'];
    public function brand(){
        return $this->belongsTo(Brand::class);
    }

}
