<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $query;
    protected $viewType;

    public function __construct($query, $viewType)
    {
        $this->query = $query;
        $this->viewType = $viewType;
    }

    public function collection()
    {
        return $this->query->get()->map(function ($item, $index) {
            switch ($this->viewType) {
                case 1:
                    return [
                        $index + 1,
                        !empty($item->merchant) ? $item->merchant->name : '',
                        $item->transaction_code,
                        $item->amount,
                        $item->fee,
                        $item->transaction_time,
                        $this->getStatusText($item->transaction_status_id),
                    ];
                case 2:
                    return [
                        !empty($item->merchant) ? $item->merchant->name : '',
                        $item->fee,
                        $this->getStatusText($item->transaction_status_id),
                    ];
                case 3: 
                    return [
                        !empty($item->merchant) ? $item->merchant->name : '',
                        $item->amount,
                        $this->getStatusText($item->transaction_status_id),
                    ];
                default:
                    return []; 
            }
        });
    }

    public function headings(): array
    {
        switch ($this->viewType) {
            case 1:
                return ['No', 'Name', 'Transaction Code', 'Amount', 'Fee', 'Date', 'Status'];
            case 2:
                return ['Name', 'Fee', 'Status'];
            case 3:
                return ['Name', 'Amount', 'Status'];
            default:
                return [];
        }
    }

    private function getStatusText($statusId)
    {
        switch ($statusId) {
            case 0:
                return 'Success';
            case 1:
                return 'Failed';
            case 2:
                return 'Pending';
            default:
                return 'Unknown';
        }
    }
}
