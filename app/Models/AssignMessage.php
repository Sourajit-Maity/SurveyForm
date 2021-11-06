<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignMessage extends Model
{
    use HasFactory;

    protected $table = 'assign_messages';
    protected $fillable = [
        'form_id', 'company_id', 'user_id',  'message'
    ];
}
