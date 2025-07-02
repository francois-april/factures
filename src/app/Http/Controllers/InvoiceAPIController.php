<?php

namespace App\Http\Controllers;

use App\Enums\InvoiceStatus;
use App\Models\Invoice;
use App\Models\InvoiceLine;
use Carbon\Carbon;
use Illuminate\Http\Request;

use function Termwind\parse;

class InvoiceAPIController extends Controller
{
    public function get_invoices(Request $request) {
        $invoices = Invoice::all();
        return response()->json([
            'invoices' =>$invoices
        ],200);
    }

    public function get_invoice_details($id) {
        $invoice = Invoice::with('invoiceLines')->find($id);
        $tableRows = [];
        foreach($invoice->invoiceLines as $invoiceLine) {
            $tableRows[] = [
                "linePosition" => $invoiceLine->id,
                "id" => $invoiceLine->id,
                "description" => $invoiceLine->description,
                "quantity" => $invoiceLine->quantity,
                "unit_price" => $invoiceLine->unit_price,
            ];

        }
        $due_at = Carbon::parse($invoice->due_at);
        $issued_at = Carbon::parse($invoice->issued_at);
        $dates = [
            "due_at" => $due_at->format('Y-m-d'),
            "issued_at" => $issued_at->format('Y-m-d')
        ];

        $subtotal = 0;
        foreach ($invoice->invoiceLines as $invoiceLine) {
            $subtotal += ($invoiceLine->unit_price * $invoiceLine->quantity);
        }
        $subtotal = number_format($subtotal, 2);
        $discountDecimal = $invoice->discount_rate / 100;
        $discountAmount = number_format($discountDecimal * $subtotal, 2);
        
        $total = number_format($subtotal - $discountAmount, 2);

        $totals = [
            "subtotal" => $subtotal,
            "discount_amount" => $discountAmount,
            "total" => $total
        ];

        return response()->json([
            'invoice' => $invoice,
            'tableRows' => $tableRows,
            'dates' => $dates,
            'totals' => $totals
        ],200);
    }

    public function create_invoice(Request $request) {
        
        $invoice = new Invoice();
        $invoice->customer_name = '';
        $invoice->currency = '';
        $invoice->discount_rate = 0;
        $invoice->status = InvoiceStatus::DRAFT;
        $invoice->issued_at = '';
        $invoice->due_at = '';

        $invoice->save();

        return response()->json([
            'invoice' =>$invoice
        ],200);
    }

    public function update_invoice(Request $request) {
        
        $invoiceId = $request->input('id');
        $invoice = Invoice::find($invoiceId);
        $invoice->customer_name = $request->input('customer_name');
        $invoice->currency = $request->input('currency');
        $discountRate = $request->input('discount_rate');
        if ((int)$discountRate >= 0 && (int)$discountRate <= 100) {
            $invoice->discount_rate = $discountRate;
        }
        $invoice->status = $request->input('status');
        $invoice->issued_at = Carbon::parse($request->input('issued_at'));
        $invoice->due_at = Carbon::parse($request->input('due_at'));

        $invoice->save();

        $invoiceLines = json_decode($request->input('invoice_lines'));
        foreach ($invoiceLines as $invoiceLineObject) {
            if ($invoiceLineObject->id) {
                $invoiceLine = InvoiceLine::find($invoiceLineObject->id);
            }
            else {
                $invoiceLine = new InvoiceLine();
                $invoiceLine->invoice_id = $invoiceId;
            }
            $invoiceLine->description = $invoiceLineObject->description;
            $invoiceLine->quantity = $invoiceLineObject->quantity;
            $invoiceLine->unit_price = $invoiceLineObject->unit_price;

            $invoiceLine->save();
        }
        return response()->json('success',200);
    }
}
