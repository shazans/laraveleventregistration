<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    public $timestamps = false;
    protected $fillable = ['AIMS', 'Position', 'Remarks', 'department_id'];
    public function dutydept()
    {
        return $this->belongsTo('App\department', 'department_id', 'id');
    }
    public function dutytajneed()
    {
        return $this->belongsTo('App\tajneed', 'AIMS', 'AIMS')->select(array('AIMS', 'name', 'Status','Mobile', 'branchcode'));
    }

}
