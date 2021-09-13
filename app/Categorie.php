<?php

namespace App;
use App\SousCategorie;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $guarded = [];
    /**
     * Get all of the sous_categorie for the Categorie
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sous_categorie()
    {
        return $this->hasMany('App\SousCategorie');
    }

    public function depense(): HasMany
    {
        return $this->hasMany(Depense::class);
    }
}
