<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardMessage extends Model
{
    use HasFactory;
    protected $table = 'forward_messages';
    protected $fillable = [
        'form_id', 'company_id', 'user_id','assign_company_id',  'message'
    ];

    public function forms()
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
    public function assigncompany()
    {
        return $this->belongsTo(AssignCompany::class,'assign_company_id');
    }
}
