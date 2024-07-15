<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\IndividualTransaction;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'type',
        'salary',
        'salary_paid_for_current_month',
    ];

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
    public function totalLoansForCurrentMonth()
    {
        return $this->loans()
            ->whereMonth('loan_date', date('m'))
            ->whereYear('loan_date', date('Y'))
            ->sum('amount');
    }

    public function individualTransactions()
    {
        return $this->hasMany(IndividualTransaction::class, 'driver_id');
    }

    public static function tipsForCurrentMonth()
    {
        $currentMonth = date('m');
        $currentYear = date('Y');

        return IndividualTransaction::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('tips');
    }
    public function remainingSalary()
    {
        $totalTips = self::tipsForCurrentMonth();
        $totalEmployees = Employee::count();

        $tipsPerEmployee = $totalEmployees > 0 ? $totalTips / $totalEmployees : 0;
        $totalLoans = $this->totalLoansForCurrentMonth();
        return $this->salary - $totalLoans + $tipsPerEmployee;
    }

    public function hasReceivedSalaryForCurrentMonth()
    {
        return $this->salary_paid_for_current_month;
    }
}
