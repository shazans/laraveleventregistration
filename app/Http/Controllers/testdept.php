<?php

namespace App\Http\Controllers;
use lluminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use DB;
use Input;
class testController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = \App\department::all();
        //$aims = \App\department::all();
        //dd($aims);
       
         return view('departments', compact('departments') );
        // return view('departments')->with('departments', $departments)->with('aims', $aims);
   
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

/*condensed way
    branch::create(request(['newbranchcode', 'newbranchname' 'newregioncode']));
*/
//retrieve form inputs and save
$department = new \App\department;
$department->deptname = request('newdeptname');
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
    $department->deptname=request('deptname');
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
    $department->delete();
    return redirect('/departments');
    }

    public function allDuties($id)
    {
//$deptSelected = Input::get('cmbDept');    
        $dutyholders = \App\Duty::where('department_id', '=', $id)->get(['id', 'aims']);
        //return json_encode($dutyholders);
return $dutyholders;
        
        //return view('dutyholders', compact('departments', 'dutyholders'));
        //return view('dutyholders', compact('dutyholders','departments'));
    }

    public function dropdown()
    {
        $departments = \App\department::all();
        
        return view('departments', compact('departments') );
        
   

        //return view('dutyholders', compact('departments'));
    }

}
