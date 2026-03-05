<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table      = 'Utilisateur';
    protected $primaryKey = 'id_user';

    public $rememberTokenName = false; 
    public    $timestamps = false;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'mot_de_passe',
        'role',
        'actif',
    ];

    public function getAuthPassword()
    {
        return $this->mot_de_passe;
    }
}