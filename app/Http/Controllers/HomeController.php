<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $products = Product::all();
        $users = User::all();
        $earningsValue = $this->getTotalCommission();
        $earnings = $this->getAnualCommission();
        return view('layouts.dashboard', compact(['products', 'users', 'earningsValue', 'earnings']));
    }

    private function getTotalCommission()
    {
        $invoicesRaw = $this->getInvoices();
        $invoiceValue = 0;
        foreach ($invoicesRaw as $invoice) {
            $invoiceValue += $invoice->value;
        }
        return $invoiceValue;
    }

    // Get monthly commission, return and array where each index is the month and the 
    // value is the commission earned on that month.        
    private function getAnualCommission($isValue = false)
    {
        $invoicesRaw = $this->getInvoices(true);

        // Convert the $invoices array to "simple array"
        $invoices = array_fill(0, 12, 0);
        foreach ($invoices as $key => $invoice) {
            foreach ($invoicesRaw as $invoiceRaw) {
                if ($key == ($invoiceRaw->month - 1)) {
                    $invoices[$key] = $invoiceRaw->value;
                }
            }
        }
        return json_encode($invoices);
    }

    private function getInvoices($hasWhere = false)
    {
        $currentYear = date("Y");

        return ($hasWhere ?
            DB::table('invoices')
            ->selectRaw('date_format(created_at, "%c") as month')
            ->selectRaw('sum(commission) as value')
            ->groupByRaw('year(created_at), month(created_at)')
            ->orderByRaw('year(created_at), month(created_at)')
            ->whereRaw('year(created_at) = ?', [$currentYear])
            ->get()

            :

            DB::table('invoices')
            ->selectRaw('date_format(created_at, "%c") as month')
            ->selectRaw('sum(commission) as value')
            ->groupByRaw('year(created_at), month(created_at)')
            ->orderByRaw('year(created_at), month(created_at)')
            ->get());
    }
}
