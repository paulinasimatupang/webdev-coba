<?php
namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function exportPDF()
    {
        $data = ['title' => 'Test PDF Title'];
        $pdf = Pdf::loadView('pdf.template', $data);
        return $pdf->download('filename.pdf');
    }
}
