<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'email', 'address', 'token', 'date_corp', 'certificate_path', 'incorp_path', 'created_at', 'updated_at', 	
    ];

    public function businessbios(){
        return $this->hasOne(BusinessBio::class, 'business_id');
    }

}
