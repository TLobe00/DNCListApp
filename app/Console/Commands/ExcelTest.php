<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Models\Dnclist;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\FromArray;

class ExcelTest extends Command implements FromArray
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:test';

    private $exporttoexcel = null;
    private $exporttoexcelrow = null;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct() {
		$this->exporttoexcel = array();
        $this->exporttoexcelrow = array();
		parent::__construct();
	}

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $collection = (new FastExcel)->import(storage_path('app/phonelist/OH-Cities-Senior-Owner.xlsx'));

        //var_dump($collection);
        $rowcount = 1;
        foreach( $collection as $obj ) {
            $this->loopXlsx( $obj, $rowcount );
            $rowcount++;
        }



        return Command::SUCCESS;
    }

    public function loopXlsx( $obj, $row ) {

        $replacestr = array('(',')','-');
        $checknumberformat = str_replace($replacestr,'',$obj['Wireless 1']);

        $checknumberarray = explode(" ", $checknumberformat);


        if (isset($checknumberarray[1])) {
            $checknumber = Dnclist::where('area_code',$checknumberarray[0])->where('phone_number',$checknumberarray[1])->get()->first();
            if (is_object($checknumber)) {
                print $checknumber;
                print "\n";
                array_push($this->exporttoexcel, $obj);
                array_push($this->exporttoexcelrow, $row);
            }
        }

        //$checknumber = Dnclist::find($obj['Wireless 1']);

        //print $checknumber;

        //var_dump($obj);
    }

    public function array(): array
    {
        return $this->exporttoexcel;
    }
}

/*
public function styles(Worksheet $sheet)
{
    $sheet->getStyle('B2')->getFont()->setBold(true);
}
return [
    'fill' => [
        'fillType'   => Fill::FILL_SOLID,
        'startColor' => ['argb' => Color::RED],
    ],
];
*/