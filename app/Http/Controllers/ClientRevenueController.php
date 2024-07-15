<?php


namespace App\Http\Controllers;

use App\Models\ClientRevenue;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientRevenueController extends Controller
{
    public function index()
    {
        $revenues = ClientRevenue::with('client')->get();
        return view('client_revenues.index', compact('revenues'));
    }

    public function create()
    {
        $clients = Client::all();
        return view('client_revenues.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'details' => 'nullable|string|max:255'
        ]);

        ClientRevenue::create($request->all());

        return redirect()->route('client_revenues.index')->with('success', 'Revenue added successfully.');
    }
}

