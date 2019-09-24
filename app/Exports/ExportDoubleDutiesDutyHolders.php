<?php

namespace App\Exports;

use App\Duty;
use lluminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Log;
use Session;

class ExportDoubleDutiesDutyHolders implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    //private $duties;

//    public function __construct($duties)
  //  {
       // $this->dduty = $duties;
       
    //}

    public function collection()
    {
        //return all dutyholders
        $data = Session::get('duties');
        return collect($data);
       
    }

    //first row is headings
    public function headings(): array
    {
        return [
            'AIMS',
            'Department',
            'Position',
            'Name'
        ];
    }

    //set headings to bold
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet()->getStyle('A1:H1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }



}
