<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Module extends Model {
    protected $table = 'Module';
    protected $primaryKey = 'id_module';
    public $timestamps = false;
    protected $fillable = ['code_module', 'nom_module', 'id_semestre'];

    /**
     * Get the semester this module belongs to
     */
    public function semestre(): BelongsTo
    {
        return $this->belongsTo(Semestre::class, 'id_semestre', 'id_semestre');
    }

    /**
     * Get the teachings for this module
     */
    public function enseignements(): HasMany
    {
        return $this->hasMany(Enseignement::class, 'id_module', 'id_module');
    }
}