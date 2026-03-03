<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamation extends Model {
    protected $table = 'Reclamation';
    protected $primaryKey = 'id_reclamation';
    public $timestamps = false;
    protected $fillable = ['message', 'statut', 'id_note', 'id_user'];
}