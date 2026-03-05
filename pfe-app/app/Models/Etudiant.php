<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Etudiant extends Model {
    protected $table = 'Etudiant';
    protected $primaryKey = 'id_user';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_user', 'cne', 'id_filiere', 'annee_actuelle'];

    /**
     * Get the user associated with this student
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}