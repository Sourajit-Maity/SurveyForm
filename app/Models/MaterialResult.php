<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialResult extends Model
{
    use HasFactory; 
    protected $table = 'material_results';

    protected $fillable = ['result_id','form_id','company_id','user_id',
    'product_name','package','market','location','percentage','user_name','user_email','company_name',
        ];
}
