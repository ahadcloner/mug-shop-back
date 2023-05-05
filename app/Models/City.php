<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=[
        'created_at',
        'updated_at',
        'state_id'
    ];
    public function state()
    {
        return $this->hasOne(State::class ,'id','state_id');

    }
}
