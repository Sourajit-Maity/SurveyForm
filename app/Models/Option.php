<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory; 
    use SoftDeletes; 
    
    protected $table = "options";
    protected $fillable = ["question_id", "option","child_id","number","message",'deleted_at'];


    public function question()
    {
        
         return $this->belongsTo(Question::class,'question_id');
    }

}
