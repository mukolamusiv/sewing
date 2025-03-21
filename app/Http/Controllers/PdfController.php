<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;

class PdfController extends Controller
{

    public function OrderPdf($order)
    {
        $order = Order::find($order);
        //dd($order);
        //$pdf = Pdf::loadView('demopdf', compact('order'));
        $pdf = FacadePdf::loadView('pdf.order', compact('order'));
        return $pdf->download('order_' . $order->id . '.pdf');
       // return $pdf->download('order.pdf');
    }
}
