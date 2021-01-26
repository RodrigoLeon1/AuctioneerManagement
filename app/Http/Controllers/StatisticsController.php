<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class StatisticsController extends Controller
{

	public function index(Request $request)
	{
		$from = null;
		$to = null;
		$total = 0;
		$invoices = null;

		if ($request->has('from') && $request->has('to')) {

			$from = date($request->input('from'));
			$to = date($request->input('to'));

			if ($request->input('from') && !$request->input('to')) {
				if ($request->input('type') === 'ambos') {
					$invoices = Invoice::whereDate('created_at', $from)->get();
				} else {
					$invoices = Invoice::whereDate('created_at', date($from))
						->where('type_invoice', $request->input('type'))
						->get();
				}
			} else {
				if ($request->input('type') === 'ambos') {
					$invoices = Invoice::whereBetween('created_at', [$from, $to])->get();
				} else {
					$invoices = Invoice::whereBetween('created_at', [$from, $to])
						->where('type_invoice', $request->input('type'))
						->get();
				}
			}
			foreach ($invoices as $invoice) {
				$total += $invoice->total;
			}
		}
		return view('estadisticas.index', compact('from', 'to', 'invoices', 'total'));
	}
}
