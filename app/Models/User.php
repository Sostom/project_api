<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone',
        'password',
        'email',
		'remember_token',
        'state'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public function roles()
	{
		return $this->belongsToMany(Role::class, 'role_users')
					->withPivot('id','role_id')
					->withTimestamps();
	}
    
    public function hasRole(array $roles){
        return $this->roles()->whereIn('name', $roles)->first();
    }

    
    public static $RegisterRule = [
        'name' => 'required',
		'phone' => 'required',
        'password' => 'required|confirmed',
        
    ];
    

    public static $rulesPasswordForgot = [
        'phone' => 'required'
    ];

    public static $rulesMessage = [
        'name' => 'required',
        'phone' => 'required',
        'message' => 'required'
    ];
    
    public static $ResetPasswordRule = [
        'phone' => 'required',
        'password' => 'required|confirmed',
    ];


    public static $modifyPasswordRule = [
        'phone' => 'required',
        'old_password' => 'required',
        'password' => 'required|confirmed',
    ];

    
    public static $UpdateRule = [
        'name' => 'required',
        'phone' => 'required',
        'email' => 'nullable',
    ];

    public function getstateAttribute($attib)
    {
        return [
            '0' => "Bloqué",
            '1' => "Actif",
        ][$attib];
    }
}
