<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class region extends Model
{
    //
    public function regionbranch()
{
    //return $this->hasMany(App\branch, 'regioncode', 'regioncode');
    return $this->hasMany(App\branch, 'id', 'regioncode');
}
}
