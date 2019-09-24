<?php

namespace App\Imports;

use App\branch;
use App\region;
use lluminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Redirect;



class BranchImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

      //if record exists update otherwise create it
      $branch = branch::where('branchcode', '=',$row[0])->first();
      $region =  region::where('regioncode', '=',$row[2])->first();
     	
      if ($branch){
               
                  //$branch->branchcode= $row[0];
                  $branch->branchname = $row[1];
                 // $branch->regioncode = $row[2];
                 $branch->regioncode = $region->id;
                  $branch->save();
                  return $branch;
             }
      else{
                 return new branch([
                 'branchcode'=> $row[0],
                 'branchname' => $row[1],
                 //'regioncode' => $row[2],
                 'regioncode' => $region->id,
                ]);
        
          }
      
      }


    //Rules for validation  
    public function rules():array
    {
        return (['0' => 'required',
        '1' => 'required',
        '2' => 'required|exists:regions,regioncode',
              ]);
    }

    public function customValidationMessages()
    {
        return ['0.required'=>'Branchcode not valid','1.required'=>'BranchName not valid','2.required'=>'RegionCode not valid','2.exists'=>'RegionCode Does Not Exist',];
    }

}
