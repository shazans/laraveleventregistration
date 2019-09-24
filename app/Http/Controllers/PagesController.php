<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function home()
    {
    return view('login');
    }

    public function dutyholders()
    {
    return view('dutyholders');
    }

    public function branches()
    {
    $branches = \App\branch::all();    
    return view('branches', compact('branches'));
    }


    
    public function storebranch()
    {
    
    $branch = new \App\branch;
    $branch->branchcode = request('branchcode');
    $branch->branchname=request('branchname');
    $branch->regioncode=request('regioncode');   
    $branch->save();
    return redirect('/branches');
    }
}
