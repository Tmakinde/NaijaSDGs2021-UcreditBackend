<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBio extends Model
{
    use HasFactory;

    protected $table = 'user_bios';

    protected $fillable = [
        'dob', 'bvn', 'tin', 'nin', 'loan_amount', 'monthly_income', 'expense', 'loan_purpose', 'created_at', 'updated_at'
    ];

    public function users(){
        return $this->belongsTo(User::class);
    }

}
