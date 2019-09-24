<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class department extends Model
{
    protected $table = 'departments';
    public $timestamps = false;
    public function duties()
    {
        return $this->hasMany(App\Duty, id, department_id);
    }

}
