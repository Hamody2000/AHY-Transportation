<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function index()
    {
        try {
            $clients = Client::all();
            $clientData = [];
            $typeTranslations = [
                'company' => 'شركات',
                'individual' => 'أفراد',
            ];

            foreach ($clients as $client) {
                // Calculate total received
                $totalReceived = $client->individualTransactions->sum('total_received')
                                + $client->companyTransactions->sum('total_received')
                                + $client->transactions()->where('type', 'credit')->sum('amount');

                // Calculate total spent
                $totalSpent = $client->individualTransactions->sum('total_spent')
                              + $client->companyTransactions->sum('total_spent')
                              + $client->transactions()->where('type', 'debit')->sum('amount');

                $clientData[] = [
                    'client' => $client,
                    'total_received' => $totalReceived,
                    'total_spent' => $totalSpent,
                    'balance' => $totalReceived - $totalSpent,
                ];
            }
            return view('clients.index', compact('clientData', 'clients', 'typeTranslations'));
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'حدث خطأ أثناء جلب بيانات العملاء: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'contact' => 'nullable|string|max:255',
        ]);

        try {
            Client::create($request->all());
            return redirect()->route('clients.index')->with('success', 'تم إضافة العميل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'حدث خطأ أثناء إضافة العميل: ' . $e->getMessage());
        }
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'contact' => 'nullable|string|max:255',
        ]);

        try {
            $client->update($request->all());
            return redirect()->route('clients.index')->with('success', 'تم تحديث بيانات العميل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'حدث خطأ أثناء تحديث بيانات العميل: ' . $e->getMessage());
        }
    }

    public function destroy(Client $client)
    {
        try {
            $client->delete();
            return redirect()->route('clients.index')->with('success', 'تم حذف العميل بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'حدث خطأ أثناء حذف العميل: ' . $e->getMessage());
        }
    }

    public function showTransactions($id)
    {
        try {
            $client = Client::with(['individualTransactions', 'companyTransactions'])->findOrFail($id);
            return view('clients.transactions', compact('client'));
        } catch (\Exception $e) {
            return redirect()->route('clients.index')->with('error', 'حدث خطأ أثناء جلب معاملات العميل: ' . $e->getMessage());
        }
    }

    public function addTransaction(Request $request, $clientId)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'client_id' => 'required|exists:clients,id'
        ]);

        try {
            $client = Client::findOrFail($clientId);
            // Create a new transaction
            $transaction = new Transaction;
            $transaction->client_id = $request->client_id;
            $transaction->amount = $request->amount;
            $transaction->type = $request->type;
            $transaction->save();

            $this->updateClientTotals($clientId);

            // Redirect back with a success message
            return redirect()->back()->with('success', 'تمت إضافة المعاملة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة المعاملة: ' . $e->getMessage());
        }
    }

}
