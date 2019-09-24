<?php

namespace App\Imports;

use App\tajneed;
use lluminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Redirect;



class TajneedImport implements ToModel, WithValidation


{
  
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
     

    
      //if record exists update otherwise create it
      $aims = tajneed::where('AIMS', '=',$row[1])->first();
     	
      if ($aims){
               
                  $aims->Status= $row[0];
                  $aims->Name = $row[2];
                  $aims->branchcode = $row[4];
                  $aims->save();
                  return $aims;
             }
      else{
                 return new tajneed([
                 'Status'=> $row[0],
                 'AIMS' => $row[1],
                 'Name' => $row[2],
                 'Mobile' => $row[3],
                 'branchcode' => $row[4],
                ]);
        
          }
    
      
    }


    //Rules for validation  
    public function rules():array
    {
        return (['0' => 'required',
        '1' => 'required',
        '2' => 'required',
        '4' => 'required|exists:branches,branchcode',
        ]);
    }

    public function customValidationMessages()
    {
        return ['0.required'=>'Status not valid','1.required'=>'AIMS not valid','2.required'=>'Name not valid','4.required'=>'Branch not valid','4.exists'=>'Branch Does Not Exist',];
    }

}
