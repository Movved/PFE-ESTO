<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model {
    protected $table = 'Evaluation';
    protected $primaryKey = 'id_evaluation';
    public $timestamps = false;
    protected $fillable = ['libelle', 'type', 'date_evaluation', 'id_module'];
}