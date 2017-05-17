<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
	protected $guarded = ['id'];

	public function sentTo ()
	{
		return $this->belongsTo(User::class, 'to_id');
	}

	public function sentFrom ()
	{
		return $this->belongsTo(User::class, 'from_id');
	}

	public function anonymous ()
	{
		return $this->belongsTo(User::class, 'anon_id');
	}
}
