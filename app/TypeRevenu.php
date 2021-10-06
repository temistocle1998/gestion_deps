<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeRevenu extends Model
{
	private $guarded =[];
    public function revenu(): HasMany
    {
        return $this->hasMany(Revenu::class);
    }
}
