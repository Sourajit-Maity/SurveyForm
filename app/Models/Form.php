<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'forms';
    protected $fillable = [
        'emp_id', 'form_name',
    ];

    public function question()
    {
         return $this->hasMany(Question::class);
    }

    public function assignform()
    {
         return $this->hasMany(AssignCompany::class);
    }

    public function comment(){
        return $this->hasMany(AssignMessage::class);
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable')->whereNull('parent_id');
    }
    public function forwardmessage()
    {
         return $this->hasOne(ForwardMessage::class);
    }
}
