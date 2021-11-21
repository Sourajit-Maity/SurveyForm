<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;
    protected $fillable = [
        'company_name', 'res_company_name', 'website_name', 'phone',
        'address', 'logo', 'gst_no','company_details'
    ];

    public function user()
    {
         return $this->hasMany(User::class);
    }
    public function assignform()
    {
         return $this->hasMany(AssignCompany::class);
    }
    public function roleparents()
    {
         return $this->hasMany(RoleParent::class);
    }
    public function comments(){
     return $this->hasMany(AssignMessage::class);
 }
 
 public function forwardmessage()
    {
         return $this->hasOne(ForwardMessage::class);
    }
}
