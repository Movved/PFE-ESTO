<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $table = 'Note';
    protected $primaryKey = 'id_note';
    public $timestamps = false;
    protected $fillable = ['note', 'rattrapage', 'note_finale', 'id_user', 'id_evaluation'];
}