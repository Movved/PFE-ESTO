<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AnneeAcademique extends Model {
    protected $table = 'Annee_Academique';
    protected $primaryKey = 'id_annee';
    public $timestamps = false;
    protected $fillable = ['libelle', 'id_filiere'];

    /**
     * Get the filiere this academic year belongs to
     */
    public function filiere(): BelongsTo
    {
        return $this->belongsTo(Filiere::class, 'id_filiere', 'id_filiere');
    }

    /**
     * Get the semesters for this academic year
     */
    public function semestres(): HasMany
    {
        return $this->hasMany(Semestre::class, 'id_annee', 'id_annee');
    }
}