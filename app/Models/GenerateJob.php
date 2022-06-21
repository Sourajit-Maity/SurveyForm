<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GenerateJob extends Model
{
    use HasFactory;

    protected $fillable = 
    ['generate_id', 'company_id'];
        public function assign_generate()
        {
            
             return $this->hasMany(AssignCompany::class);
        }

        public function assign_generate_company()
        {
            
             return $this->belongsTo(Company::class, 'company_id');
        }
}


