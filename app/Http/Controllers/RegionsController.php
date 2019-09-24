<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;

class RegionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = \App\region::orderBy('regionname', 'asc')->get();    
        return view('regions', compact('regions'));
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
        //retrieve form inputs and validate 
        request()->validate([
            'newregioncode' =>['required', 'min:1', 'unique:regions,regioncode'],
            'newregioname' =>['required'],
        ]);

        //save region
        $region = new \App\region;
        $region->regioncode = strtoupper(request('newregioncode'));
        $region->regionname=ucwords(strtolower(request('newregioname')));  
        $region->save();
        return redirect('/regions');   
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    //update Region name
    $region = \App\region::find($id);
    $region->regionname=ucwords(strtolower(request('regionname')));
    $region->save();
    return redirect('/regions');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    
        //find region and dont delete if branches exist in the region
        $region = \App\region::findOrFail($id);
        if(\App\branch::where('regioncode', '=', $id)->count()>0){
            return redirect()->back()->withErrors(['Please Delete Branches in this Region first']);         }
        else{
            $region->delete();
            return redirect('/regions');
        }
    
    }
}
