<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;
    protected $table = 'results';

    protected $fillable = ['result_id','form_id','question_id','child_question_id','question','answer','user_id'];

    public function assignresult()
    {
         return $this->hasOne(AssignResult::class);
    }

    public function reportmessage()
    {
        
         return $this->hasMany(ReportMessages::class);
    }
}
