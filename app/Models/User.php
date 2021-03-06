<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Company;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'company_id',
        'password',
        'user_image',
        'spoc',
        'phone_number',
        'reporting_to_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function company()
    {
         return $this->belongsTo(Company::class,);
    }
    public function manager()
    {
         return $this->hasMany(Company::class);
    }
    public function assignform()
    {
         return $this->hasMany(AssignCompany::class);
    }
    public function roleparents()
    {
         return $this->hasMany(RoleParent::class);
    }
    public function comments(){
        return $this->hasMany(AssignMessage::class);
    }
    public function forwardmessage()
    {
         return $this->hasOne(ForwardMessage::class);
    }

    public function formcreatedby(){
        return $this->hasMany(Form::class);
    }
    public function formupdatedby(){
        return $this->hasMany(Form::class);
    }

    public function questioncreatedby(){
        return $this->hasMany(Question::class);
    }
    public function questionupdatedby(){
        return $this->hasMany(Question::class);
    }

    public function reportusername()
    {
        
         return $this->hasMany(ReportMessages::class);
    }
}
