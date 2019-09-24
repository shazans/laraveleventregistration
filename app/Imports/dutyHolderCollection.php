<?php

namespace App\Imports;

use App\Duty;
use App\department;
use Log;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
//use Maatwebsite\Excel\Concerns\WithHeadingRow;


class dutyHolderCollection implements ToCollection

{
    public function collection(Collection $rows)
    {
       foreach ($rows as $row) 
        {
//return $rows;
          //  Duty::create([
            return new Duty([
                'aims' => $row[0],
                'position' =>  $row[2], 
                 'department'=>  $row[1],
                'name'=> $row[5],
                'branch'=> $row[6],
            ]);
        }
    }
}

