<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchWallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'bank',
        'cash',
        'balance'
    ];

    public function user(){
        return $this->belongsTo(Customer::class);
    }
}
