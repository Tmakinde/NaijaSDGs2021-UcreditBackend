<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BusinessBio extends Model
{
    use HasFactory;

    protected $fillable = [
        'cac_no', 'tin_no', 'revenue', 'capital', 'current_debt', 'prev_debt', 'loan_amount', 'loan_purpose', 'created_at', 'updated_at', 'business_id'	
    ];

    public function businesses(){
        return $this->belongsTo(Business::class);
    }

}
