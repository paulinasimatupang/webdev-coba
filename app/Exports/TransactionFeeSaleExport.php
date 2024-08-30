<?php

namespace App\Exports;

use App\Entities\TransactionFeeSale;
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
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

//class TransactionBJBExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithColumnFormatting, WithEvents, WithStyles, WithTitle
class TransactionFeeSaleExport implements FromView, WithColumnFormatting, WithEvents, WithStyles, WithTitle, ShouldAutoSize
{
    use Exportable;
    public function __construct(Request $request){
    	$this->request = $request;
    }

    public function title(): string
    {
        return 'REPORT_DETAIL';
    }

    public function headings(): array
    {
        return [
	'stan',
	'request_time',
	'tx_time',
	'tid',
	'mid',
	'agent_name',
	'billid',
	'proc_code',
	'message_status',
	'rc',
	'status',
	'reversal_stan',
	'reversal_rc',
	'host_ref',
	'tx_pan',
	'product_name',
	'transaction_name',
	'nominal',
	'fee',
	'agent_fee',
	'bjb_fee',
	'selada_fee',
	'buffer_14',
	'total',
	'src_account',
	'dst_account'
        ];
    }

    public function map($transaction): array{
	return [
	$transaction->stan,
	$transaction->request_time,
	$transaction->tx_time,
	$transaction->tid,
	$transaction->mid,
	$transaction->agent_name,
	$transaction->billid,
	$transaction->proc_code,
	$transaction->message_status,
	$transaction->rc,
	$transaction->status,
	$transaction->reversal_stan,
	$transaction->reversal_rc,
	$transaction->host_ref,
	$transaction->tx_pan,
	$transaction->product_name,
	$transaction->transaction_name,
	$transaction->nominal,
	$transaction->fee,
	$transaction->agent_fee,
	$transaction->bjb_fee,
	$transaction->selada_fee,
	$transaction->buffer_14,
	$transaction->total,
	$transaction->src_account,
	$transaction->dst_account
	];
    }

    public function columnFormats(): array
    {
        return [
	'A' => NumberFormat::FORMAT_NUMBER,
	'B' => NumberFormat::FORMAT_NUMBER,
	'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'I' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
	'J' => NumberFormat::FORMAT_NUMBER
	    ];
    }

    public function registerEvents(): array
    {
        return [
        AfterSheet::class    => function(AfterSheet $event) {
		$cellRange = 'E:E';
                $event->sheet->getDelegate()->getStyle($cellRange)
                        ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
                                        ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		// $cellRange = 'H:H';
        //         $event->sheet->getDelegate()->getStyle($cellRange)
        //                 ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
        //                                 ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		// $cellRange = 'U:U';
        //         $event->sheet->getDelegate()->getStyle($cellRange)
        //                 ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT)
        //                                 ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		// $cellRange = 'V:V';
        //         $event->sheet->getDelegate()->getStyle($cellRange)
        //                 ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_JUSTIFY)
        //                                 ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$cellRange = 'A1:J1';
		$event->sheet->getDelegate()->getStyle($cellRange)
			->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)
					->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

		$event->sheet->getDelegate()->getStyle('A1:J'.($this->rowCount+1))->applyFromArray(
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
		'A1:J1' => ['font' => ['bold' => true]]
	];
    }

    public function view() : View
    {
	$request = $this->request;
	$data = TransactionFeeSale::select('tid', 
                                        'mid',	
                                        'agent_name');
//        $data = TransactionBJB::query();

//	if(!$this->request->has('service') || $this->request->get('service')=='' || $this->request->get('status')=='Select Service'){
//	
            $data->selectRaw('SUM(CAST(fee as int)) as total_amount_fee');
            $data->selectRaw('sum(CAST(agent_fee as int)) as fee_agen');
            $data->selectRaw('sum(CAST(bjb_fee as int)) as fee_bjb');
            $data->selectRaw('sum(CAST(selada_fee as int)) as fee_selada');
            $data->selectRaw('sum(CAST(buffer_14 as int)) as buffer');
            $data->selectRaw('SUM(CAST(total as int)) as total_amount_transaction');
            $data->selectRaw('count(*) as total_transaction');
        	$data->whereNull('reversal_stan');
        	$data->where('rc', '=', '00');
            $data->where('message_status', '=', '00');
        	$data->whereNotNull('stan');
//	}

        if($this->request->has('start_date') && $this->request->get('start_date')!=''){
            $data->where('tx_time', '>', $this->request->get('start_date').' 00:00:00');
        }

        if($this->request->has('end_date') && $this->request->get('end_date')!=''){
            $data->where('tx_time', '<=', $this->request->get('end_date').' 23:59:59');
        }


        // if($this->request->has('tid') && $this->request->get('tid')!=''){
        //     $data->where('tid', '=', $this->request->get('tid'));
        // }
        // if($this->request->has('mid') && $this->request->get('mid')!=''){
        //     $data->where('mid', '=', $this->request->get('mid'));
        // }
        // if($this->request->has('agent_name') && $this->request->get('agent_name')!=''){
        //     $data->where('agent_name', '=', $this->request->get('agent_name'));
        // }
        // if($this->request->has('message_status') && $this->request->get('message_status')!=''){
        //         $data->where('message_status', '=', $this->request->get('message_status'));
        // }
        // if($this->request->has('status') && $this->request->get('status')!='' && $this->request->get('status')!='Select Status'){
        //     if ($this->request->get('status') == 'Success'){
        //         $data->where('rc', '=', '00');
        //         $data->whereNull('reversal_stan');
        //     } else {
        //         $data->where(function($query)
        //         {
        //             $query->where('rc', '!=', '00')
        //             ->orWhereNotNull('reversal_stan');
        //         });
        //     }
        // }
        
        // if($this->request->has('rc') && $this->request->get('rc')!=''){
        //     $data->where('rc', '=', $this->request->get('rc'));
        // }

        // if($this->request->has('stan') && $this->request->get('stan')!=''){
        //     $data->where('stan', '=', $this->request->get('stan'));
        // }

//	dd($data->toSql());die();

    $data->groupBy('tid', 'mid', 'agent_name');
    $data->orderBy('tid', 'asc');

	$data = $data->get();
    
	$this->rowCount = $data->count();
    
	//return $data->query();
//	return $data;
	return view('exports.transactions_fee_sale', [
            'data' => $data
        ]);
   }
}
