<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model {
    protected $table = 'Etudiant';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_user', 'cne', 'id_filiere', 'annee_actuelle'];
}