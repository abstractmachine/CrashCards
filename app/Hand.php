<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hand extends Model
{
    public function team()
    {
    	return $this->belongsTo(Team::class);
    }

    public function cards()
    {
    	return $this->belongsToMany(Card::class);
    }
}
