<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormReview extends Model
{
    use HasFactory;
    use SoftDeletes; 
    
    protected $table = "form_reviews";
    protected $fillable = ["form_id","from_company_id",'from_employee_id',"to_company_id",'to_employee_id', "status", "message", "deleted_at"];


    

}
