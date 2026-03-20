<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'utilisateur';
    protected $primaryKey = 'id_user';
    public $timestamps = false; 

    public $rememberTokenName = false;

    protected $fillable = [
        'nom', 'prenom', 'email', 'mot_de_passe', 'role', 'actif'
    ];

    protected $hidden = ['mot_de_passe'];

    // Map 'mot_de_passe' to Laravel's internal password system
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}