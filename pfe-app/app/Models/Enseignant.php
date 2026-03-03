<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignant extends Model {
    protected $table = 'Enseignant';
    protected $primaryKey = 'id_user';
    public $incrementing = false; 
    public $timestamps = false;
    protected $fillable = ['id_user', 'specialite', 'departement', 'is_chef'];
}
