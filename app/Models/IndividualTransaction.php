<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class IndividualTransaction extends Model
{
    use HasFactory;
    protected $casts = [
        'date' => 'date',
        'detention_date_car' => 'date',
        'detention_date_client' => 'date',


    ];

    protected $fillable = [
        'client_id',
        'date',
        'location_from',
        'location_to',
        'fare',
        'overnight_stay',
        'representative_name',
        'commission',
        'remaining_truck_fare',
        'final_truck_fare',
        'loading',
        'transfer',
        'weight',
        'driver_name',
        'vehicle_id',
        'detention',
        'total_received', 'total_spent', 'remaining_for_client', 'remaining_from_client', 'spend_details',
        'fare', 'commission', 'tip', 'remaining_fare', 'advance', 'is_overnight_days_active', 'vehicle_plate_number',
        'agreed_days_with_client', 'agreed_days_with_vehicle', 'overnight_days', 'overnight_price_with_client',
        'overnight_price_with_vehicle', 'net_overnight',
        'total_amount',
        'truck_fare',
        'company_commission',
        'vehicle_allowance',
        'tips',
        'is_finished',
        'finished_at',
        'driver_id_photo',
        'detention_date_client', 'detention_date_car',
    ];
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function driver()
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }
    public function spends()
    {
        return $this->hasMany(Spend::class, 'transaction_id');
    }
    public function getTotalSpentAttribute()
    {
        // @dd($this->OvernightForClient);
        return $this->spends->sum('value') + $this->detention + $this->loading + $this->fare + $this->OvernightForClient;
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }


    // public function getOvernightDaysAttribute()
    // {
    //     $transactionDate = $this->date;
    //     $agreedDaysEnd = $transactionDate->copy()->addDays($this->agreed_days_with_client);

    //     // Get the current date
    //     $currentDate = now(); // or Carbon::now()

    //     // Calculate the difference in days between the current date and the end of agreed days
    //     $daysPassed = $agreedDaysEnd->diffInDays($currentDate, false); // use false for negative values if the date hasn't passed
    //     // If days passed is positive, return it; otherwise, return 0
    //     return $daysPassed > 0 ? $daysPassed : 0;
    // }
    // IndividualTransaction.php
    // public function getOvernightDaysAttribute()
    // {
    //     if (!$this->is_overnight_days_active) {
    //         return 0; // Or another appropriate value when counting is paused
    //     }

    //     $transactionDate = $this->date;
    //     $agreedDaysEnd = $transactionDate->copy()->addDays($this->agreed_days_with_client);

    //     $currentDate = now(); // or Carbon::now()
    //     $daysPassed = $agreedDaysEnd->diffInDays($currentDate, false);

    //     return $daysPassed > 0 ? $daysPassed : 0;
    // }
    // IndividualTransaction.php
public function getOvernightDaysAttribute()
{
    if ($this->is_finished) {
        return $this->attributes['overnight_days']; // Return the saved overnight days if the transaction is finished
    }

    $transactionDate = $this->date;
    $agreedDaysEnd = $transactionDate->copy()->addDays($this->agreed_days_with_client);

    $currentDate = now(); // or Carbon::now()
    $daysPassed = $agreedDaysEnd->diffInDays($currentDate, false);

    return $daysPassed > 0 ? $daysPassed : 0;
}


    public function getNetOvernightAttribute()
    {
        // if ($this->agreed_days_with_client == 0) {
        //     return 0;
        // }
        return $this->overnight_days * ($this->overnight_price_with_client - $this->overnight_price_with_vehicle);
    }
    public function getOvernightForClientAttribute()
    {
        // if ($this->agreed_days_with_client == 0) {
        //     return 0;
        // }
        return $this->overnight_days * $this->overnight_price_with_client;
    }
}
