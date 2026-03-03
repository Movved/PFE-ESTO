<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAction extends Model {
    protected $table = 'log_action';
    protected $primaryKey = 'id_log';
    public $timestamps = false;
    protected $fillable = ['action', 'table_concernee', 'id_enregistrement', 'id_user'];
}