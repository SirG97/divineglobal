<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchTransaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id','user_type', 'option', 'branch_id','customer_id','txn_ref','txn_type','purpose', 'amount',
        'balance_before', 'balance_after', 'description', 'count', 'date'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function manager(){
        return $this->belongsTo(Manager::class);
    }
}
