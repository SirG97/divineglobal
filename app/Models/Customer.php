<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'surname',
        'middle_name',
        'dob',
        'sex',
        'account_id',
        'resident_state',
        'resident_lga',
        'resident_address',
        'occupation',
        'office_address',
        'state',
        'lga',
        'hometown',
        'phone',
        'next_of_kin',
        'relationship',
        'nokphone',
        'acc_no',
        'branch',
        'group',
        'sb_card_no_from',
        'sb_card_no_to',
        'sb',
        'initial_unit',
        'user_id',
        'wallet_id',
        'branch_id',
        'bank_name',
        'bank_code',
        'account_name',
        'account_number',

    ];

    public function user(){
        return $this->belongsTo(User::class);
    }



    public function branch(){
        return $this->belongsTo(Branch::class, 'branch_id');
    }
}
