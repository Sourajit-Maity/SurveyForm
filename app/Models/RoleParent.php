<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleParent extends Model
{
    use HasFactory;
    protected $table = 'role_parents';

    protected $fillable = ['company_id','designation_name','parent_id'];
}
