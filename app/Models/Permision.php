<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use mysql_xdevapi\Table;

class Permision extends Model
{
    use HasFactory;

    protected $table ='permissions';
    protected $guarded=[];
    protected $hidden=[
        'created_at',
        'updated_at'
    ];
}
