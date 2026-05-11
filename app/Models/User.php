<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, HasApiTokens, Notifiable;

    /**
     * Atributos asignables (Mass assignable).
     * Se incluye 'username' tal como lo requiere el endpoint de registro.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username', 
    ];

    /**
     * Atributos ocultos para la serialización.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casteo de atributos.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Relación con el Perfil del usuario[cite: 4, 17].
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * Relación con las Publicaciones (Posts)[cite: 50, 76].
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Relaciones para el sistema de Mensajería.
     */
    public function sentMessages()
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages()
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    /**
     * Relación de Amigos aceptados[cite: 109, 113].
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id', 'friend_id')
            ->withPivot('status')
            ->wherePivot('status', 'accepted');
    }
}