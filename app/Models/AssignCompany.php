<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignCompany extends Model
{
    use HasFactory;
    protected $table = 'assign_companies';
    protected $fillable = [
        'message', 'company_id','employee_id', 'form_id', 'assign', 'forward', 'user_id', 'user_company_id'
    ];

    public function company()
    {
        
         return $this->belongsTo(Company::class,'company_id');
    }
    public function assigncompany()
    {
        
         return $this->belongsTo(Company::class,'user_company_id');
    }

    public function form()
    {
        
         return $this->belongsTo(Form::class,'form_id');
    }

    public function employee()
    {
        
         return $this->belongsTo(User::class,'employee_id');
    }
    public function assignuser()
    {
        
         return $this->belongsTo(User::class,'user_id');
    }
}
