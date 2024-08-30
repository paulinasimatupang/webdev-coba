<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Merchant;

class MerchantsExport implements FromCollection, WithHeadings
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
            return [
                $index + 1, // No
                $item->id,
                $item->no,
                $item->name,
                $item->email,
                $item->address,
                $item->phone,
                $item->terminal_id,
                $item->status_agen,
                $item->active_at,
                $item->resign_at,
            ];
        });
    }

    public function headings(): array
    {
        switch ($this->viewType) {
            case 1:
                return ['No', 'Id', 'Account No', 'Name', 'Email', 'Address', 'Phone', 'TID', 'Status Agen', 'Activate Date', 'Resign Date'];
            default:
                return [];
        }
    }
}
