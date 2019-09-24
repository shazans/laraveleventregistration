<?php

namespace App\Http\Controllers;
use lluminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
//use DB;
//use Input;
class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$departments = \App\department::all();
        $departments = \App\department::orderBy('deptname', 'asc')->get();
        return view('departments', compact('departments') );       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)   {
        
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
         'newdeptname' =>['required'],
          ]);

        //retrieve form inputs and save
        $department = new \App\department;
        $department->deptname = ucwords(strtolower(request('newdeptname')));
        $department->save();
        return redirect('/departments');
    }
    

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
     //update department name
    $department = \App\department::find($id);
    $department->deptname=ucwords(strtolower(request('deptname')));
    $department->save();
    return redirect('/departments');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //find dept
    $department = \App\department::find($id);
    if(\App\Duty::where('department_id', '=', $id)->count()>0){
        return redirect()->back()->withErrors(['Please Delete Dutyholders in this Department First']);         }
    else{
        $department->delete();
        return redirect('/departments');
    }
    }

    public function allDuties($id)
    {
        $dutyholders = \App\Duty::where('department_id', '=', $id)->get(['id', 'aims']);
        return $dutyholders;
     
    }

    public function dropdown()
    {
        $departments = \App\department::all();
        return view('departments', compact('departments') );
    }

}
