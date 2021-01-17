<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\invoice;
use App\pay;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function get_invoices()
    {
        $invoices = invoice::leftjoin('pay','pay.invoice_id','=','invoice.id')->get();
        return $invoices;
    }
    public function new_invoice(Request $request)
    {
        $amount = $request->input()['amount'];
        $description = $request->input()['description'];
        $schoolname = $request->input()['schoolname'];
        $invoice = new invoice();
        $invoice->description = $description;
        $invoice->schoolname = $schoolname;
        $invoice->amount = $amount;
        $invoice->invoicelink = Str::uuid();
        $invoice->save();
        return $invoice->id;
    }
    public function get_invoice($invoicelink)
    {
        $invoice = invoice::select('invoice.id as id','schoolname','description','amount','fullname','status')->leftjoin('pay','pay.invoice_id','=','invoice.id')->where('invoicelink','=',$invoicelink)->first();
        return $invoice;
    }
    public function pay(Request $request)
    {
        $fullname = $request->input()['fullname'];
        $status = $request->input()['status'];
        $invoice_id = $request->input()['invoice_id'];
        $pay = new pay();
        $pay->fullname = $fullname;
        $pay->status = $status;
        $pay->invoice_id = $invoice_id;
        $pay->save();
        return $pay->id;
    }
    public function payer($invoicelink)  //render pay
    {
        return view('payer',['invlink'=>$invoicelink]);
    }
}
