<?php

namespace App\Exports;

use App\Duty;
use lluminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class ExportDutyHolders implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return all dutyholders
        $data = Duty::join('departments', 'duties.department_id', '=', 'departments.id')->
          join('tajneed', 'duties.AIMS', '=', 'tajneed.AIMS')->
          join('branches', 'branches.branchcode', '=', 'tajneed.branchcode')->
          get(['duties.AIMS','tajneed.Name','tajneed.Status', 'tajneed.Mobile','branches.branchname','departments.deptname','duties.Position', 'duties.Remarks' ]);

        return $data;
    }

    //first row is headings
    public function headings(): array
    {
        return [
            'AIMS',
            'Name',
            'Status',
            'Mobile',
            'Branch',
            'Department',
            'Position',
            'Remarks'
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
