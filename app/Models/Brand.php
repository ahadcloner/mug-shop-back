<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Helper\Table;

class Brand extends Model
{
    use HasFactory;
    protected $table ='brands';
    protected $guarded=[];
    protected $hidden=['created_at','updated_at'];
}
