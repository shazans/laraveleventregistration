<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     //list all branches - called when page loaded
    public function index()
    {
        $branches = \App\branch::all();    
        $regions = \App\region::all();    
        //return view('branches', compact('branches', 'regions'));
        $data = \App\branch::with('branchregion')->orderBy('branchname', 'asc')->get();
        return view('branches', compact('data','regions'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    //validate user data entered
      request()->validate([
            'newbranchcode' =>['required', 'min:3', 'unique:branches,branchcode'],
            'newbranchname' =>['required'],
            'newregioncode' =>['required'],

      ]);

    /*condensed way
        branch::create(request(['newbranchcode', 'newbranchname' 'newregioncode']));
    */
    //retrieve form inputs and save
    $branch = new \App\branch;
    $branch->branchcode = strtoupper(request('newbranchcode'));
    $branch->branchname= ucwords(strtolower(request('newbranchname')));
    $branch->regioncode=strtoupper(request('newregioncode'));   
    $branch->save();
    return redirect('/branches');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
*/
/**
    public function edit($id)
    {
        return $id;
    }
*/
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    //update branch details after being passed branchcode from form
    $branch = \App\branch::find($id);
    $branch->branchcode = strtoupper(request('branchcode'));
    $branch->branchname=ucwords(strtolower(request('branchname')));
  //  $branch->regioncode=request('regioncode');   
    $branch->save();
    return redirect('/branches');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //find and dont delete if exists in tajneed
    $branch = \App\branch::find($id);
    if(\App\tajneed::where('branchcode', '=', $branch->branchcode)->count()>0){
        return redirect()->back()->withErrors(['Unable to Delete Branches as they exist in Tajneed']);         
    }
    else{
        $branch->delete();
        return redirect('/branches');
    }
    }
}
