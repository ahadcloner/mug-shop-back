<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductTag extends Model
{
    use HasFactory;
    protected $table = 'product_tags';
    protected $guarded =[];
    protected $hidden =['created_at','updated_at','product_id' ,'tag_id','id'];
    public function tag(){
        return $this->belongsTo(Tag::class);
    }

}
;
