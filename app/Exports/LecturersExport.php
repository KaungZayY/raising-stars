<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LecturersExport implements FromQuery, ShouldAutoSize, WithHeadings, WithStyles
{
    Use Exportable;

    //Used Query for this Export, Options Exists, Checkout Collections, etc
    public function query()
    {
        return User::select('name','email','phone_number','address')->where('role_id',2);
    }

    //Excel Headers
    public function headings(): array
    {
        return ["Name", "Email", "Phone Number", "Address"];
    }

    //Simple Styles for Headers
    public function styles(Worksheet $sheet)
    {
        //'1' means, the first row,
        $sheet->getStyle('A1:' . $sheet->getHighestColumn() . '1')->applyFromArray([
            'font' => [
                'bold' => true,
            ],
        ]);
    }

}
