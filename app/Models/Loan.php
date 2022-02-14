<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'lender_id',
        'request_amount',
        'amount',
        'paid',
        'manager_id',
        'status'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id', 'id');
    }

    public function lender(){
        return $this->belongsTo(Branch::class, 'lender_id', 'id');
    }
}
