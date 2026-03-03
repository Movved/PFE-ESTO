<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'Utilisateur';
    protected $primaryKey = 'id_user';
    public $timestamps = false; // Using date_creation instead

    protected $fillable = [
        'nom', 'prenom', 'username', 'mot_de_passe', 'role', 'actif'
    ];

    protected $hidden = ['mot_de_passe'];

    // Map 'mot_de_passe' to Laravel's internal password system
    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}