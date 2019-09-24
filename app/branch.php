<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class branch extends Model
{
    public $timestamps = false;
//public $incrementing = false;  this table does not have id as default primary key so need to set to false
protected $fillable =['branchcode', 'branchname', 'regioncode'];

public function branchtajneed()
{
    return $this->hasMany('App\tajneed', 'branchcode', 'branchcode')->select(array('branchname'));
}

public function branchregion()
{
   // return $this->belongsTo('App\region', 'regioncode', 'regioncode');
    return $this->belongsTo('App\region', 'regioncode', 'id');
}
}