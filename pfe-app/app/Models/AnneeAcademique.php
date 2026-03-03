<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnneeAcademique extends Model {
    protected $table = 'Annee_Academique';
    protected $primaryKey = 'id_annee';
    public $timestamps = false;
    protected $fillable = ['libelle', 'id_filiere'];
}