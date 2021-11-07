<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignResult extends Model
{
    use HasFactory;

    protected $table = 'assign_results';
    protected $fillable = [
        'result_id', 'material_result_id', 'assign_company_id', 'user_id'
    ];
    
}
