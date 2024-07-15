<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $casts = [
        'loan_date' => 'date',
    ];
    protected $fillable = [
        'employee_id',
        'amount',
        'loan_date',
        'comment'
    ];
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
