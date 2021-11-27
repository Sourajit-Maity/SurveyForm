<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportMessages extends Model
{
    use HasFactory;

    protected $table = "report_messages";
    protected $fillable = ["user_id", "result_id","company_id","message"];


    public function resultmessage()
    {
        
         return $this->belongsTo(Result::class,'result_id');
    }

    public function companyname()
    {
        
         return $this->belongsTo(Company::class,'company_id');
    }

    public function messageuser()
    {
        
         return $this->belongsTo(User::class,'user_id');
    }
}
