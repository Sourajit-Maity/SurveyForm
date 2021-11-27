<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignResult extends Model
{
    use HasFactory;

    protected $table = 'assign_results';
    protected $fillable = [
        'result_id','message', 'material_result_id', 'assign_company_id', 'user_id', 'share'
    ];
    public function result()
    {
         return $this->belongsTo(Result::class,);
    }
    public function material()
    {
         return $this->belongsTo(MaterialResult::class,);
    }
    public function assigncompany()
    {
         return $this->belongsTo(AssignCompany::class,'assign_company_id');
    }
    public function assignmessage()
    {
         return $this->hasMany(AssignMessage::class);
    }


}
