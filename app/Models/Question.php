<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory; 
    use SoftDeletes; 
    
    protected $table = "questions";
    protected $fillable = ["question_id", "question_type","question","form_id","company_id",'deleted_at'];


    public function form()
    {      
         return $this->belongsTo(Form::class,'form_id');
    }
    public function option()
    {
         return $this->hasMany(Option::class,'question_id');
    }
}

