<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    use HasFactory;
    protected $guarded =[];
    protected $hidden=['created_at' ,'updated_at','id','attribute_id'];
    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
