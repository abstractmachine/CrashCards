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
		return $this->belongsToMany(Category::class)->withPivot('draw_count')->withTimestamps();
	}

	public function cards()
	{
		return $this->belongsToMany(Card::class)->withPivot('id', 'category_id')->withTimestamps();
	}

	public function author()
	{
		return $this->belongsTo(User::class, 'user_id');
	}
}
