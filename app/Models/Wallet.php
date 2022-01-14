<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'user_type',
        'count',
        'balance'
    ];

    public function user(){
        return $this->belongsTo(Customer::class);
    }
}
