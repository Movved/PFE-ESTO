<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Filiere extends Model {
    protected $table = 'Filiere';
    protected $primaryKey = 'id_filiere';
    public $timestamps = false;
    protected $fillable = ['nom_filiere', 'description', 'responsable_id'];

    /**
     * Get the responsable (teacher) of this filiere
     */
    public function responsable(): BelongsTo
    {
        return $this->belongsTo(User::class, 'responsable_id', 'id_user');
    }

    /**
     * Get the academic years for this filiere
     */
    public function anneeAcademiques(): HasMany
    {
        return $this->hasMany(AnneeAcademique::class, 'id_filiere', 'id_filiere');
    }
}