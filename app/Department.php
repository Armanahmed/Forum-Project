<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public function period(){
    	return $this->hasMany('App\Period');
    }

}
