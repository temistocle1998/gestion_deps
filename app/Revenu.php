<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenu extends Model
{
    protected $guarded = [];

    public function type_revenu()
    {
        return $this->belongsTo(TypeRevenu::class);
    }

    /**
     * Get the user that owns the Revenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
