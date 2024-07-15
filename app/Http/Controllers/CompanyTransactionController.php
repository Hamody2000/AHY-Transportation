<?php

namespace App\Http\Controllers;

use App\Models\CompanyTransaction;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Vehicle;

class CompanyTransactionController extends Controller
{
    public function index()
    {
        $transactions = CompanyTransaction::with('client')->orderBy('date', 'desc')->paginate(10);
        return view('company_transactions.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = CompanyTransaction::with('client')->findOrFail($id);
        return view('company_transactions.show', compact('transaction'));
    }

    public function create()
    {
        $clients = Client::where('type', 'company')->get();
        $drivers = Employee::where('type', 'driver')->get();
        $vehicles = Vehicle::all();
        return view('company_transactions.create', compact('clients', 'drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'price_per_ton' => 'required|numeric',
            'price_per_ton_car' => 'required|numeric',
            'tonnage' => 'required|integer',
            'overnight_stay' => 'nullable|numeric',
            'location_from' => 'required|string|max:255',
            'location_to' => 'required|string|max:255',
            'driver_id' => 'nullable|exists:employees,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'total_received' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'detention' => 'nullable|numeric',
            'loading' => 'nullable|numeric',
            'transfer' => 'nullable|numeric',
        ]);

        $data = $request->all();
        $data['total'] = $data['price_per_ton'] * $data['tonnage'];
        $data['commission'] = $data['tonnage'] * ($data['price_per_ton'] - $data['price_per_ton_car']);

        CompanyTransaction::create($data);

        return redirect()->route('company_transactions.index')
            ->with('success', 'تم إنشاء المعاملة بنجاح.');
    }

    public function edit($id)
    {
        $transaction = CompanyTransaction::findOrFail($id);
        $clients = Client::where('type', 'company')->get();
        $drivers = Employee::where('type', 'driver')->get();
        $vehicles = Vehicle::all();
        return view('company_transactions.edit', compact('transaction', 'clients', 'vehicles', 'drivers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'price_per_ton' => 'required|numeric',
            'price_per_ton_car' => 'required|numeric',
            'tonnage' => 'required|integer',
            'overnight_stay' => 'nullable|numeric',
            'location_from' => 'required|string|max:255',
            'location_to' => 'required|string|max:255',
            'driver_id' => 'nullable|exists:employees,id',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'total_received' => 'required|numeric',
            'weight' => 'nullable|numeric',
            'detention' => 'nullable|numeric',
            'loading' => 'nullable|numeric',
            'transfer' => 'nullable|numeric',
        ]);

        $transaction = CompanyTransaction::findOrFail($id);
        $data = $request->all();
        $data['total'] = $data['price_per_ton'] * $data['tonnage'];
        $data['commission'] = $data['tonnage'] * ($data['price_per_ton'] - $data['price_per_ton_car']);
        $transaction->update($data);

        return redirect()->route('company_transactions.index')
            ->with('success', 'تم تحديث المعاملة بنجاح.');
    }

    public function destroy($id)
    {
        $transaction = CompanyTransaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('company_transactions.index')
            ->with('success', 'تم حذف المعاملة بنجاح.');
    }

    public function printInvoice($id)
    {
        $transaction = CompanyTransaction::findOrFail($id);
        return view('invoices.company', compact('transaction'));
    }
}
