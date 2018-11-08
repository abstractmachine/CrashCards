<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
	public function workshop()
	{
		return $this->belongsTo(Workshop::class);
	}

	public function players()
	{
		return $this->belongsToMany(User::class);
	}

	public function hand()
	{
		return $this->hasOne(Hand::class);
	}
}
