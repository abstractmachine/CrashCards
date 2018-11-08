<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    public function workshop()
    {
    	return $this->belongsTo(Workshop::class);
    }
}
