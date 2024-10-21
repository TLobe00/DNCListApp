<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\ListExport;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Excel;

class exportDNCList extends Controller
{
    //
    public function export() 
    {
        $export = new ListExport([
            [1, 2, 3],
            [4, 5, 6]
        ]);

        var_dump($export);
    
#        return Excel::download($export, 'invoices.xlsx');
    }
}
