<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Semestre extends Model {
    protected $table = 'Semestre';
    protected $primaryKey = 'id_semestre';
    public $timestamps = false;
    protected $fillable = ['numero', 'cloture', 'id_annee'];

    /**
     * Get the academic year this semester belongs to
     */
    public function anneeAcademique(): BelongsTo
    {
        return $this->belongsTo(AnneeAcademique::class, 'id_annee', 'id_annee');
    }

    /**
     * Get the modules for this semester
     */
    public function modules(): HasMany
    {
        return $this->hasMany(Module::class, 'id_semestre', 'id_semestre');
    }
}