<?php

namespace App\Models;

 use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
 use Illuminate\Support\Facades\Mail;
 use Laravel\Sanctum\HasApiTokens;
 use Illuminate\Support\Facades\URL;
 use App\Mail\CustomEmailVerification;


 class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'email_verified_at',
        'password',
        'role_id',
        'remember_token',
        'avatar'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function isAdmin(){
        return $this->role_id == 1;
    }
    public function isUser(){
        return $this->role_id == 2;
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function getNameRole()
    {
        return $this->role->name ?? 'No Role Assigned';
    }

    public function comments()
{
    return $this->hasMany(Comment::class);
}
public function orders()
    {
        return $this->hasMany(Order::class,'user_id');
    }

    // san pham yeu thich
    public function favorites(){
        return $this->belongsToMany(Product::class,'favorites');
    }
     public function sendEmailVerificationNotification()
     {
         $verificationUrl = URL::temporarySignedRoute(
             'verification.verify',
             now()->addMinutes(60),
             ['id' => $this->id, 'hash' => sha1($this->email)]
         );

         Mail::to($this->email)->send(new CustomEmailVerification($verificationUrl));
     }
}
