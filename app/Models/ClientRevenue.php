<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientRevenue extends Model
{
    use HasFactory;
    protected $casts = [
        'date' => 'date',
    ];
    protected $fillable = ['client_id', 'date', 'amount', 'details'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
