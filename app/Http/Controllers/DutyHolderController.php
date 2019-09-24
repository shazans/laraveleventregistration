<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use lluminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use DataTables;
use Log;
use Session;


class DutyHolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $departments = \App\department::all();
        $aims = \App\tajneed::all('AIMS');
        
        return view('dutyholders', compact('departments', 'aims') );
      
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find duty holder
        $dutyHolder = \App\Duty::findorFail($id);
        $dutyHolder->delete();
        exit;    
    }


    //delete all dutyholders for department
    public function deleteAll(Request $request)
    {     
        $data =\App\Duty::where('department_id', '=',$request->id)->get()->each->delete();
        $data = \App\Duty::with('dutytajneed.tajneedbranch')->where('department_id', '=',$request->id)->get();
        return DataTables::of($data)->make(true); 
            
    }



   //return all dutyholders for department
    public function selectAjax(Request $request)
    {     
       
       $data = \App\Duty::with('dutytajneed.tajneedbranch')->where('department_id', '=',$request->id)->get();
       return DataTables::of($data)->make(true); 
    }



//return dutyholder details when AIMS dropdown changes
public function getdutyholder($id)
{     
    $dutyHolder = \App\tajneed::where('AIMS', $id)->first();
    $duties = \App\Duty::with('dutydept')->where('AIMS', $id)->get();
    return response()->json(['dutyHolder' => $dutyHolder, 'duties' => $duties]);
}


//save dutyholder position, remark or mobile fields
public function editdutyholder(Request $request)
{     
    $id= $request->editid;
    $mobile = $request->mobile;
    $position = $request->position;
    $remarks = $request->remarks;
    $aims = $request->aims;


    if ($remarks == null){
        $remarks = "";
    }
    if ($mobile == null){
        $mobile = "";
    }

    //save dutyholder details
    $dutyHolder = \App\Duty::where('id', $id)->first();
    $dutyHolder->Position = $position;
    $dutyHolder->Remarks = $remarks;
    $dutyHolder->save();  

    $tajneedDutyholder = \App\tajneed::where('AIMS',$aims)->first();
    $tajneedDutyholder->Mobile = $mobile;
    $tajneedDutyholder->save();
    return response()->json(array("success"=>true));
   }

//add dutyholder position, remark or mobile fields
public function adddutyholder(Request $request)
{     
    $id= $request->id;
    $mobile = $request->mobile;
    $position = $request->position;
    $remarks = $request->remarks;
    $aims = $request->aims;
    if ($remarks == null){
        $remarks = "";
    }
    if ($mobile == null){
        $mobile = "";
    }
    request()->validate([
        'aims'=>'required',
        'position' =>'required',
        Rule::in(['Nazima', 'Naib Nazima', 'Muavina', 'Special Assistant']),
    ]);

    //save dutyholder details
    $dutyHolder = new \App\Duty;
    $dutyHolder->AIMS = $aims;
    $dutyHolder->Position = $position;
    $dutyHolder->Remarks = $remarks;
    $dutyHolder->department_id = $id;
    $dutyHolder->save();  

    $tajneedDutyholder = \App\tajneed::where('AIMS',$aims)->first();
    $tajneedDutyholder->Mobile = $mobile;
    $tajneedDutyholder->save();
    //return response()->json(array("success"=>true));
}



}
      