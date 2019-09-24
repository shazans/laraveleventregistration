<?php

namespace App\Http\Controllers;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use lluminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use App\Exports\ExportDutyHolders;
use App\Exports\ExportDeptDutyHolders;
use App\Exports\ExportDoubleDutiesDutyHolders;
use App\Imports\TajneedImport;
use App\Imports\BranchImport;
use App\Imports\dutyHolderImport;
use App\Imports\dutyHolderCollection;
use App\Exceptions\Handler;
use DB;
use Excel;
use Redirect;
use Validator;
use Exception;
use Errors;
use Log;
use Session;

class ImportExportController extends Controller
{
	public function importExport()
	{
	//	Session::forget('duties');
		 
		return view('importExport');
	}

    //download duties to excel
	public function downloadAllExcel()
	{
		//download all dutyholders to excel
        return Excel::download(new ExportDutyHolders, 'AllDutyHolders.xlsx');
	    
	}

	//download duties for a specific department to 
	public function downloadDeptExcel($addDeptId)
	{
		return Excel::download(new ExportDeptDutyHolders($addDeptId), 'DepartmentDutyHolders.xlsx');
	}

	//download double duties on import 
	public function downloadDoubleDutiesExcel()
	{
			if(Session::has('duties') && Session::get('duties') != '') {
				return Excel::download(new ExportDoubleDutiesDutyHolders(), 'DoubleDutiesDutyHolders.xlsx');
			}
			else
			{
				return redirect()->back();
			}
	}
	

	//import Tajneed Excel file
	public function importExcel(Request $request)
	{

		//validate file
		request()->validate([
			'import_file'=> 'required|mimes:xlsx,xls'
		]);	
		//import selected file

		$import = Excel::import(new TajneedImport,request()->file('import_file'));
		return redirect()->back()->with('errors', 'Errors');
		return redirect()->back()->with('success', 'Tajneed Data Successfully Uploaded');
		
	}


	//import Branches Excel file
	public function importBranchesExcel(Request $request)
	{

		//validate file
		request()->validate([
			'import_branchfile'=> 'required|mimes:xlsx,xls'
		]);	
		//import selected file

		Excel::import(new BranchImport,request()->file('import_branchfile'));
		return redirect()->back()->with('success', 'Branches Successfully Uploaded');
	}

	//import Duties Excel file
	public function importdutyHoldersExcel(Request $request)
	{

		
		if(Session::has('duties') && Session::get('duties') != '') {
			Session::forget('duties');
		}

		//validate file
		request()->validate([
			'import_dutyholdersfile'=> 'required|mimes:xlsx,xls'
		]);
		//get name of file
		$filetitle = request()->file('import_dutyholdersfile')->getClientOriginalName();

		//import selected file
		$listduties = Excel::toCollection( new dutyHolderCollection,request()->file('import_dutyholdersfile'));
		$dduties = $listduties->toArray();
		
		//loop through to get double duties
		$listduty = [];
		$numdd = 0;
		for($i = 0; $i<count($dduties[0]); $i++){
			$dutyaims = $dduties[0][$i][0];
			$doubledutiesColl = \App\Duty::with('dutydept')->where('AIMS',$dutyaims)->get();
			if($doubledutiesColl->count() > 0){

				$doubleduties = $doubledutiesColl->toArray();
				$numdd = count($doubleduties);
						
			//get dutyholder name 
			$tajneedDutyHolderColl = \App\tajneed::where('AIMS',$dutyaims)->first();
			$tajneedDutyHolder = [];
			if($tajneedDutyHolderColl->count() > 0){
				$tajneedDutyHolder = $tajneedDutyHolderColl->toArray();
			}
			if ($numdd>0){
			
				foreach($doubleduties as $duty){	
					$aims = $duty["AIMS"];
					$dept = $duty['dutydept']['deptname'];
					$position = $duty["Position"];
					$name =$tajneedDutyHolder["Name"];
					$listduty[] = ['aims' => $aims, 'dept' => $dept,'position' => $position, 'name' => $name];							
				}
			}
		 }
		}
		
		Session::put('duties',['listduty'=> $listduty, 'filetitle'=>$filetitle]);
		Excel::import(new dutyHolderImport,request()->file('import_dutyholdersfile'));
		return redirect()->back()->with('message', 'Success: File Imported');
	
	}
}