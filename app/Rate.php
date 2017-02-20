<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RateTrait;

class Rate extends Model
{
    protected $guarded = ['id'];
    
    public function user()
    {
    	return $this->belongsTo('App\User');
    }

	public function getTraitName ($id)
	{
		return RateTrait::find($id)->name;
	}
}
