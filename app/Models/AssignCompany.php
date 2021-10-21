<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignCompany extends Model
{
    use HasFactory;
    protected $table = 'assign_companies';
    protected $fillable = [
        'message', 'company_id','employee_id', 'form_id',
    ];
}
