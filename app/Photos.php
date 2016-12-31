<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photos extends Model
{
    protected $fillable = array('id', 'eventId','value', 'name', 'description');
    protected $hidden = array('id','eventId', 'created_at','updated_at');
}
