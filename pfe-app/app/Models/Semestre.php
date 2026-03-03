<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Semestre extends Model {
    protected $table = 'Semestre';
    protected $primaryKey = 'id_semestre';
    public $timestamps = false;
    protected $fillable = ['numero', 'cloture', 'id_annee'];
}