<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Workshop extends Model
{
	public function author()
	{
		return $this->belongsTo(User::class, 'author_id');
	}
    public function links()
    {
    	return $this->hasMany(Link::class);
    }

    public function deck()
    {
    	return $this->belongsTo(Deck::class);    
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

}
