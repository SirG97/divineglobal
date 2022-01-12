<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waitlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'user_type', 'branch_id','admin_id', 'manager_id'
    ];

    public function branch(){
        return $this->belongsTo(Branch::class);
    }
}
