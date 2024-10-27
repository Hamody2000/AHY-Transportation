<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyTransaction extends Model
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
        'price_per_ton',
        'price_per_ton_car',
        'commission',
        'tonnage',
        'overnight_stay',
        'location_from',
        'location_to',
        'total',
        'driver_name',
        'vehicle_id',
        'detention_date_client', 'detention_date_car',
        'loading',
        'transfer',
        'weight',
        'detention',
        'total_received',
        'spend_details',
        'driver_id_photo'

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
        return $this->spends->sum('value') + $this->detention + $this->loading + $this->transfer + $this->overnight_stay + $this->total + $this->weight;
    }
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function getOvernightDaysAttribute()
    {
        $transactionDate = $this->date;
        $agreedDaysEnd = $transactionDate->copy()->addDays($this->agreed_days_with_client);

        // Get the current date
        $currentDate = now(); // or Carbon::now()

        // Calculate the difference in days between the current date and the end of agreed days
        $daysPassed = $agreedDaysEnd->diffInDays($currentDate, false); // use false for negative values if the date hasn't passed
        // If days passed is positive, return it; otherwise, return 0
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
