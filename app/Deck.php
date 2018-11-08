<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deck extends Model
{
	public function workshops()
	{
		return $this->hasMany(Workshop::class);
	}

	public function categories()
	{
		return $this->belongsToMany(Category::class)->withPivot('draw_count');
	}

	public function cards()
	{
		return $this->belongsToMany(Card::class)->withPivot('category_id');
	}
}
