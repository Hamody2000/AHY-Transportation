<?php

namespace App\Http\Controllers;

use App\Models\IndividualTransaction;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Employee;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Storage;
use App\Notifications\DetentionDateCarNotification;

class IndividualTransactionController extends Controller
{
    public function index()
    {
        try {
            // Use pagination to limit the number of records fetched at once
            $transactions = IndividualTransaction::with('client', 'spends')
                ->orderBy('date', 'desc')
                ->paginate(10); // Adjust the number of items per page as needed

            // Calculate totals for each client
            $clientTotals = $transactions->groupBy('client_id')->map(function ($transactions) {
                return [
                    'client' => $transactions->first()->client,
                    'total_received' => $transactions->sum('total_received'),
                    'total_spent' => $transactions->sum('total_spent'),
                ];
            });

            return view('individual_transactions.index', compact('transactions', 'clientTotals'));
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'حدث خطأ أثناء جلب المعاملات: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $transaction = IndividualTransaction::with('client')->findOrFail($id);
            return view('individual_transactions.show', compact('transaction'));
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'لم يتم العثور على المعاملة: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $clients = Client::where('type', 'individual')->get();
        $drivers = Employee::where('type', 'driver')->get();
        $vehicles = Vehicle::all();
        return view('individual_transactions.create', compact('clients', 'drivers', 'vehicles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'location_from' => 'required|string|max:255',
            'location_to' => 'required|string|max:255',
            'fare' => 'required|numeric',
            'truck_fare' => 'nullable|numeric',
            'remaining_truck_fare' => 'nullable|numeric',
            'vehicle_allowance' => 'nullable|numeric',
            'driver' => 'nullable|string|max:255',
            'vehicle_id' => 'required|exists:vehicles,id',
            'agreed_days_with_client' => 'required|integer',
            'agreed_days_with_vehicle' => 'required|integer',
            'overnight_price_with_client' => 'required|numeric',
            'overnight_price_with_vehicle' => 'required|numeric',
            'total_received' => 'required|numeric',
            'detention' => 'nullable|numeric',
            'transfer' => 'nullable|numeric',
            'loading' => 'nullable|numeric',
            'driver_id_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4048', // Limit file size to 2MB
            'detention_date_client' => 'nullable|date',
            'detention_date_car' => 'nullable|date',
        ]);

        try {
            $data = $request->all();
            // Handle the photo upload
            if ($request->hasFile('driver_id_photo')) {
                $photoPath = $request->file('driver_id_photo')->store('driver_photos', 'public');
                $data['driver_id_photo'] = $photoPath;
            }
            $data['commission'] = $data['fare'] - $data['truck_fare'];
            $data['remaining_truck_fare'] = $data['truck_fare'] - ($data['tips'] ?? 0);
            $data['final_truck_fare'] = $data['remaining_truck_fare'] - ($data['vehicle_allowance'] ?? 0);
            $transaction = IndividualTransaction::create($data);

            if (isset($request->spends) && is_array($request->spends)) {
                foreach ($request->spends as $spend) {
                    $transaction->spends()->create($spend);
                }
            }

            $transaction->update([
                'overnight_days' => $transaction->overnight_days
            ]);

     
            //-------------------------------------------------------------
            return redirect()->route('individual_transactions.index')
                ->with('success', 'تمت إضافة المعاملة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.create')
                ->with('error', 'حدث خطأ أثناء إضافة المعاملة: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $transaction = IndividualTransaction::findOrFail($id);
            $clients = Client::where('type', 'individual')->get();
            $vehicles = Vehicle::all();
            $drivers = Employee::where('type', 'driver')->get();

            return view('individual_transactions.edit', compact('transaction', 'clients', 'vehicles', 'drivers'));
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'لم يتم العثور على المعاملة: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'date' => 'required|date',
            'location_from' => 'required|string|max:255',
            'location_to' => 'required|string|max:255',
            'fare' => 'required|numeric',
            'commission' => 'nullable|numeric',
            'truck_fare' => 'nullable|numeric',
            'remaining_truck_fare' => 'nullable|numeric',
            'vehicle_allowance' => 'nullable|numeric',
            'driver' => 'nullable',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'agreed_days_with_client' => 'required|integer',
            'agreed_days_with_vehicle' => 'required|integer',
            'overnight_price_with_client' => 'required|numeric',
            'overnight_price_with_vehicle' => 'required|numeric',
            'total_received' => 'required|numeric',
            'detention' => 'nullable|numeric',
            'transfer' => 'nullable|numeric',
            'loading' => 'nullable|numeric',
            'driver_id_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:4048', // Limit file size to 2MB
            'detention_date_client' => 'nullable|date',
            'detention_date_car' => 'nullable|date',

        ]);

        try {
            $transaction = IndividualTransaction::findOrFail($id);
            $data = $request->all();

            $data['commission'] = $data['fare'] - $data['truck_fare'];
            $data['remaining_truck_fare'] = $data['truck_fare'] - ($data['tips'] ?? 0);
            $data['final_truck_fare'] = $data['remaining_truck_fare'] - ($data['vehicle_allowance'] ?? 0);
          // Handle the new driver photo upload
          if ($request->hasFile('driver_id_photo')) {
            // Delete the old photo if it exists
            if ($transaction->driver_id_photo) {
                Storage::delete('public/' . $transaction->driver_id_photo);
            }

            // Store the new photo and update the data array
            $photoPath = $request->file('driver_id_photo')->store('driver_photos', 'public');
            $data['driver_id_photo'] = $photoPath;
        }
            $transaction->update($data);
            $transaction->spends()->delete(); // Remove old spends
            if (isset($request->spends) && is_array($request->spends)) {
                foreach ($request->spends as $spend) {
                    $transaction->spends()->create($spend);
                }
            }
            $transaction->update([
                'overnight_days' => $transaction->overnight_days
            ]);
            return redirect()->route('individual_transactions.index')
                ->with('success', 'تمت تحديث المعاملة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.edit', $id)
                ->with('error', 'حدث خطأ أثناء تحديث المعاملة: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $transaction = IndividualTransaction::findOrFail($id);
            $transaction->delete();

            return redirect()->route('individual_transactions.index')
                ->with('success', 'تمت حذف المعاملة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'حدث خطأ أثناء حذف المعاملة: ' . $e->getMessage());
        }
    }

    public function printInvoice($id)
    {
        try {
            $transaction = IndividualTransaction::findOrFail($id);
            return view('invoices.individual', compact('transaction'));
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'لم يتم العثور على المعاملة للطباعة: ' . $e->getMessage());
        }
    }
    // IndividualTransactionController.php
    public function toggleOvernightDays($id)
    {
        try {
            $transaction = IndividualTransaction::findOrFail($id);

            // Toggle the is_overnight_days_active status
            $transaction->update([
                'is_overnight_days_active' => !$transaction->is_overnight_days_active,
            ]);

            $message = $transaction->is_overnight_days_active ? 'تم استئناف حساب الأيام المبيت بنجاح.' : 'تم إيقاف حساب الأيام المبيت بنجاح.';

            return redirect()->route('individual_transactions.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'حدث خطأ أثناء تغيير حالة حساب الأيام المبيت: ' . $e->getMessage());
        }
    }
    // IndividualTransactionController.php
    public function finishTransaction($id)
    {
        try {
            $transaction = IndividualTransaction::findOrFail($id);

            // Update the transaction to mark it as finished
            $transaction->update([
                'is_finished' => true,
                'finished_at' => now(),
                'overnight_days' => $transaction->overnight_days, // Save the current overnight days
            ]);

            return redirect()->route('individual_transactions.index')
                ->with('success', 'تم إنهاء المعاملة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('individual_transactions.index')
                ->with('error', 'حدث خطأ أثناء إنهاء المعاملة: ' . $e->getMessage());
        }
    }
}
