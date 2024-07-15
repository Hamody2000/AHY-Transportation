<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    protected $fillable = ['transaction_id', 'value', 'spend_details'];

    public function transaction()
    {
        return $this->belongsTo(IndividualTransaction::class, 'transaction_id');
    }
}
