<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributeValue extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden =['created_at','updated_at','id','product_id','attribute_value_id'];
    public function attribute_value(){
        return $this->belongsTo(AttributeValue::class);
    }
}
