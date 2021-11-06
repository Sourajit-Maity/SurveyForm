<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForwardMessage extends Model
{
    use HasFactory;
    protected $table = 'forward_messages';
    protected $fillable = [
        'form_id', 'company_id', 'user_id',  'message'
    ];
}
