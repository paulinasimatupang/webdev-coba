<?php

namespace App\Exports;

use App\Entities\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionExport implements FromView, WithColumnFormatting, WithEvents, WithStyles, WithTitle, ShouldAutoSize
{
    use Exportable;
    public function __construct(Request $request){
        $this->request = $request;
    }

    public function title(): string
    {
        return 'REPORT_DETAIL';
    }

    public function columnFormats(): array
    {
        return [
	'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
	];
    }

    public function registerEvents(): array
    {
        return [
        AfterSheet::class    => function(AfterSheet $event) {
	$cellRange = 'A1:K1';
                $event->sheet->getDelegate()->getStyle($cellRange)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
                                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
	$event->sheet->getDelegate()->getStyle('A1:K'.($this->rowCount+1))->applyFromArray(
                        [
                                'borders' => [
                                        'allBorders' => [
                                                'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
                                        ],
                                ]
                        ]
                );
	}
	];
    }

    public function styles(Worksheet $sheet)
    {
        return [
                'A1:K1' => ['font' => ['bold' => true]]
        ];
    }

    public function query()
    {
	$request = $this->request;
	$data = Transaction::select('*');
	$data = $data->with(['merchant.terminal','merchant.user','service.product.provider.category','transactionStatus','transactionPaymentStatus']);
	
	if($this->request->has('start_date') && $this->request->get('start_date')!=''){
            $data->where('created_at', '>', $this->request->get('start_date').' 00:00:00');
        }

        if($this->request->has('end_date') && $this->request->get('end_date')!=''){
            $data->where('created_at', '<=', $this->request->get('end_date').' 23:59:59');
        }


        if($this->request->has('tid') && $this->request->get('tid')!=''){
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('terminal_id', '=', $this->request->get('tid'));
                });
        }
        if($this->request->has('mid') && $this->request->get('mid')!=''){
            // $data->where('merchant.mid', '=', $this->request->get('mid'));
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('mid', '=', $this->request->get('mid'));
                });
        }
        if($this->request->has('agent_name') && $this->request->get('agent_name')!=''){
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('name', '=', $this->request->get('agent_name'));
                });
        }
        if($this->request->has('status') && $this->request->get('status')!='' && $this->request->get('status')!='Select Status'){
            $status = $this->request->get('status');
            if ($status == 'Pending'){
                $data->where('status', '=', 0);
            }
            else if ($status == 'Success'){
                $data->where('status', '=', 1);
                
            } else if ($status == 'Failed'){
                $data->where('status', '=', 2);
            }
            
        }
        if($this->request->has('stan') && $this->request->get('stan')!=''){
            $data->where('stan', '=', $this->request->get('stan'));
        }
        $data->where('is_development','!=',1);
        $data->where('is_marked_as_failed','!=',1);

	$data->orderBy('created_at', 'desc');
	$this->rowCount = $data->count();

	return $data->getQuery();
    }

    public function view(): View
    {
	 $request = $this->request;
        $data = Transaction::select('*');
        $data = $data->with(['merchant.terminal','merchant.user','service.product.provider.category','transactionStatus','transactionPaymentStatus']);
        
        if($this->request->has('start_date') && $this->request->get('start_date')!=''){
            $data->where('created_at', '>', $this->request->get('start_date').' 00:00:00');
        }

        if($this->request->has('end_date') && $this->request->get('end_date')!=''){
            $data->where('created_at', '<=', $this->request->get('end_date').' 23:59:59');
        }


        if($this->request->has('tid') && $this->request->get('tid')!=''){
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('terminal_id', '=', $this->request->get('tid'));
                });
        }
        if($this->request->has('mid') && $this->request->get('mid')!=''){
            // $data->where('merchant.mid', '=', $this->request->get('mid'));
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('mid', '=', $this->request->get('mid'));
                });
        }
        if($this->request->has('agent_name') && $this->request->get('agent_name')!=''){
            $data->whereHas('merchant',function($query) use ($request)
                {
                    $query->where('name', '=', $this->request->get('agent_name'));
                });
        }
        if($this->request->has('status') && $this->request->get('status')!='' && $this->request->get('status')!='Select Status'){
            $status = $this->request->get('status');
            if ($status == 'Pending'){
                $data->where('status', '=', 0);
            }
            else if ($status == 'Success'){
                $data->where('status', '=', 1);
                
            } else if ($status == 'Failed'){
                $data->where('status', '=', 2);
            }
            
        }
        if($this->request->has('stan') && $this->request->get('stan')!=''){
            $data->where('stan', '=', $this->request->get('stan'));
        }
        $data->where('is_development','!=',1);
	$data->where('is_marked_as_failed','!=',1);

        $data->orderBy('created_at', 'desc');
        $this->rowCount = $data->count();
	
	$data = $data->get();

	foreach($data as $item){
            if($item->status == 0){
                $item->status_text = 'Pending';
            }

            if($item->status == 1){
                $item->status_text = 'Success';
            }

            if($item->status == 2){
                $item->status_text = 'Failed';
            }

            $item->fee = $item->price - $item->vendor_price;
        }
        return view('exports.transactions', [
            'data' => $data
        ]);
    }
}

