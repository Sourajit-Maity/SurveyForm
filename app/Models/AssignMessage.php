<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignMessage extends Model
{
    use HasFactory;

    protected $table = 'assign_messages';
    protected $fillable = [
        'form_id', 'company_id', 'user_id', 'assign_result_id', 'message'
    ];

    public function post()
    {
        return $this->belongsTo(Form::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(User::class);
    }
    public function assignresult()
    {
        return $this->belongsTo(AssignResult::class,'assign_result_id');
    }
}
