<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name', 'res_company_name', 'tax_id',
        'spoc_id', 'email', 'phone',
        'address', 'logo', 'gst_no'
    ];

    public function user()
    {
         return $this->hasMany(User::class);
    }
}
