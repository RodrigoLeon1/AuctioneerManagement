<?php

namespace App\Http\Controllers;

use App\Models\InvoiceProforma;
use Illuminate\Http\Request;

class InvoiceProformaController extends Controller
{

    public function index()
    {
        $invoices = InvoiceProforma::all();
        return view('proformas.index', compact('invoices'));
    }

    public function create()
    {
        return view('proformas.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }
}
