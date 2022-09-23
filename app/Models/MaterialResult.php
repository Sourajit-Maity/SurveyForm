<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialResult extends Model
{
    use HasFactory; 
    protected $table = 'material_results';

    protected $fillable = 
    ['result_id','form_id','company_id','user_id','assign_company_id',
        'material_code','product_name','package','market','location','percentage','project_name','project_date','attachment',
        'user_name','user_email','company_name','company_logo'
        ];

        public function assignresult()
        {
             return $this->hasOne(AssignResult::class);
        }

        public function assigncompany()
        {
             return $this->belongsTo(AssignCompany::class,'assign_company_id');
        }
}
