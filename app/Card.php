<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function hands()
    {
    	return $this->belongsToMany(Hand::class);
    }
    
    public function decks()
    {
    	return $this->belongsToMany(Deck::class)->withPivot('id', 'category_id')->withTimestamps();
    }
}
