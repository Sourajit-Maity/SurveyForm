<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;
class RoleParent extends Model
{
    use HasFactory;
    protected $table = 'role_parents';

    protected $fillable = ['company_id','designation_id','parent_id'];

    public function company()
    {      
         return $this->belongsTo(Company::class,'company_id');
    }
    public function parent()
    {      
         return $this->belongsTo(User::class,'parent_id');
    }
    public function roles()
    {      
         return $this->belongsTo(Role::class,'designation_id');
    }
}
