<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscription extends Model {
    protected $table = 'Inscription';
    protected $primaryKey = 'id_inscription';
    public $timestamps = false;
    protected $fillable = ['id_user', 'id_semestre'];
}