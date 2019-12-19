<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function category() {
    	return $this->belongsTo('App\Category');
    }

    public function file(){
    	return $this->hasMany('App\File');
    }

    public function comment(){
    	return $this->hasMany('App\Comment');
    }
}
