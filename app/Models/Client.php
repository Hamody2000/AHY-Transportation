<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transaction;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'phone',
        'total_received', 'total_spent'
    ];
    public function individualTransactions()
    {
        return $this->hasMany(IndividualTransaction::class);
    }

    public function companyTransactions()
    {
        return $this->hasMany(CompanyTransaction::class);
    }
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
    
}

