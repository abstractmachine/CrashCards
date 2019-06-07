<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'color', 'background_color', 'index'];

	public function decks()
	{
		return $this->belongsToMany(Deck::class);
	}
}
