<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enseignement extends Model {
    protected $table = 'Enseignement';
    protected $primaryKey = 'id_enseignement';
    public $timestamps = false;
    protected $fillable = ['id_user', 'id_module'];
}