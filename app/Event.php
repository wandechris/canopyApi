<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = array('id', 'name','categoryId','category','description','duration','startDate','time','city','country','address');

    protected $hidden = array('categoryId', 'created_at','updated_at');
}
