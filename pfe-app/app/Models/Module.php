<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model {
    protected $table = 'Module';
    protected $primaryKey = 'id_module';
    public $timestamps = false;
    protected $fillable = ['code_module', 'nom_module', 'id_semestre'];
}