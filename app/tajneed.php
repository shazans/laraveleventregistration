<?php

namespace App;
use Illuminate\Database\Eloquent\Model;


class tajneed extends Model
{
    //
    protected $table = 'tajneed';

    protected $fillable =['AIMS', 'Name', 'Status','branchcode', 'Mobile'];
    //protected $guarded = ['AIMS', 'name', 'Status','branchcode', 'Mobile'];
  //  protected $primaryKey = 'AIMS'; 
   // public $incrementing = false;
    public $timestamps = false;

    public function tajneedduty()
    {
        return $this->hasMany('App\Duty', 'AIMS', 'AIMS');
    }

    public function tajneedbranch()
    {
        return $this->belongsTo('App\branch', 'branchcode', 'branchcode')->select(array('branchcode','branchname'));
    }
}
