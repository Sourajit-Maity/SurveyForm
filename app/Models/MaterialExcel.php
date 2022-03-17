<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialExcel extends Model
{
    use HasFactory;
    protected $fillable = 
    ['assign_company_id','user_id',
        'key_name','value'

        ];
        public function assign_material()
        {
            
             return $this->belongsTo(AssignCompany::class, 'assign_company_id');
        }
}
