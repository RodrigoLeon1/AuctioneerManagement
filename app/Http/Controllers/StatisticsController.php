<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\InvoiceProforma;

class StatisticsController extends Controller
{

	public function index(Request $request)
	{
		$from = null;
		$to = null;
		$total = 0;
		$quantity = 0;
		$commission = 0;
		$invoices = null;
		$invoicesProforma = null;

		if ($request->has('from') && $request->has('to')) {

			$from = date($request->input('from'));
			$to = date($request->input('to'));

			if ($request->input('from') && !$request->input('to')) {
				if ($request->input('type') === 'liquidado') {
					$invoices = Invoice::whereDate('created_at', date($from))
						->where('type_invoice', 'cliente')
						->get();
				} else {
					$invoicesProforma = InvoiceProforma::whereDate('date_remate', date($from))
						->where('is_invoiced', 0)
						->get();
				}
			} else {
				if ($request->input('type') === 'liquidado') {
					$invoices = Invoice::whereBetween('created_at', [$from, $to])
						->where('type_invoice', 'cliente')
						->get();
				} else {
					$invoicesProforma = InvoiceProforma::whereBetween('date_remate', [$from, $to])
						->where('is_invoiced', 0)
						->get();
				}
			}

			if ($invoices) {
				foreach ($invoices as $invoice) {
					foreach ($invoice->products as $product) {
						$quantity += $product->pivot->quantity;
					}
					$commission += $invoice->commission;
					$total += $invoice->subtotal;
				}
			}

			if ($invoicesProforma) {
				foreach ($invoicesProforma as $invoice) {
					$commission += $invoice->commission_value;
					$quantity += $invoice->quantity;
					$total += $invoice->partial_total;
				}
			}
		}
		return view('estadisticas.index', compact('from', 'to', 'invoices', 'total', 'quantity', 'commission', 'invoicesProforma'));
	}
}
