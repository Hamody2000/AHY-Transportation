<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        try {
            $vehicles = Vehicle::all();
            return view('vehicles.index', compact('vehicles'));
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')->with('error', 'حدث خطأ أثناء جلب المركبات.');
        }
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20',
            'details' => 'nullable|string|max:255',
        ]);

        try {
            Vehicle::create($validated);
            return redirect()->route('vehicles.index')->with('success', 'تمت إضافة المركبة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.create')->with('error', 'حدث خطأ أثناء إضافة المركبة.');
        }
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', compact('vehicle'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $validated = $request->validate([
            'license_plate' => 'required|string|max:20',
            'details' => 'nullable|string|max:255',
        ]);

        try {
            $vehicle->update($validated);
            return redirect()->route('vehicles.index')->with('success', 'تم تحديث بيانات المركبة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.edit', $vehicle->id)->with('error', 'حدث خطأ أثناء تحديث بيانات المركبة.');
        }
    }

    public function destroy(Vehicle $vehicle)
    {
        try {
            $vehicle->delete();
            return redirect()->route('vehicles.index')->with('success', 'تم حذف المركبة بنجاح.');
        } catch (\Exception $e) {
            return redirect()->route('vehicles.index')->with('error', 'حدث خطأ أثناء حذف المركبة.');
        }
    }
}
