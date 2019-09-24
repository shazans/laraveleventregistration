<?php

namespace App\Imports;

use App\Duty;
use App\department;
use App\tajneed;
use lluminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Validation\Rule;
use Redirect;
use Log;



class dutyHolderImport implements ToModel, WithValidation
//, WithProgressBar
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
     
      //get dept id for department  
     $dept = department::where('deptname', '=',$row[1])->first();
     if ($row[3] == null){
         $row[3]='';
     }


     //create duty record
      
                 return new Duty([
                 'AIMS'=> $row[0],
                 'department_id' => $dept->id,
                 'Position' => ucwords(strtolower($row[2])),
                 'Remarks' => $row[3],
                 ]);
                  
    }
      
    //Rules for validation  
    public function rules():array
    {
        return (['0' => 'required|exists:tajneed,AIMS',
        '1' => 'required|exists:departments,deptname',
        '2' => 'required',
        //'2' => Rule::in(['Nazima', 'Naib Nazima', 'Muavina', 'Special Assistant']),
        '2' => function($attribute, $value, $onFailure) {
                 if ( ucwords(strtolower($value)) === 'Muavina' OR ucwords(strtolower($value)) === 'Nazima' OR ucwords(strtolower($value)) === 'Naib Nazima' OR ucwords(strtolower($value)) === 'Special Assistant') 
                    {                
                        return ucwords(strtolower($value));
  
                    }
                    $onFailure('Position is not Valid');

                }
        ]);
    }

    public function customValidationMessages()
    {
        return ['0.required'=>'AIMS not valid','1.required'=>'Department Name not valid','2.required'=>'Position not valid',
        ];
    }

    public function customValidationAttributes()
{
    return ['0' => 'AIMS', '1' => 'Department', '2' => 'Position',];
}

}


