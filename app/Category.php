<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = array('id', 'name', 'description');
     protected $hidden = array('created_at','updated_at');
}
