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
      $from = $request->input('from');
      $to = $request->input('to');
      if ($request->input('type') === 'ambos') {
        $invoices = Invoice::whereBetween('created_at', [$from, $to])->get();
      } else {
        $invoices = Invoice::whereBetween('created_at', [$from, $to])
          ->where('type_invoice', $request->input('type'))
          ->get();
      }
      foreach ($invoices as $invoice) {
        $total += $invoice->total;
      }
    }
    return view('estadisticas.index', compact('from', 'to', 'invoices', 'total'));
  }
}
