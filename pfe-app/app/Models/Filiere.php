<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filiere extends Model {
    protected $table = 'Filiere';
    protected $primaryKey = 'id_filiere';
    public $timestamps = false;
    protected $fillable = ['nom_filiere', 'description', 'responsable_id'];
}