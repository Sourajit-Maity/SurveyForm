<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    protected $table = 'forms';
    protected $fillable = [
        'emp_id', 'form_name',
    ];

    public function user()
    {
         return $this->hasMany(Question::class);
    }
}
