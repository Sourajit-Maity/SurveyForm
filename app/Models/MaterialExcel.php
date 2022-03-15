<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialExcel extends Model
{
    use HasFactory;
    protected $fillable = 
    ['assign_company_id','user_id',
        'material_code','product_name','package','market','location','product_code','project_name','project_date'

        ];
}
