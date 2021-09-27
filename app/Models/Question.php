<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Question extends Model
{
    use HasFactory;
    
    protected $table = "questions";
    protected $fillable = ["question_id", "question_type","question","options","form_id","company_id"];


    public function form()
    {
         return $this->belongsTo(Form::class,);
    }
}
