<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class projectInvitation extends Model
{
    protected $guarded = ['id'];

	public function toUser ()
	{
		return $this->belongsTo(User::class, 'to_id');
	}

	public function fromUser ()
	{
		return $this->belongsTo(User::class, 'from_id');
	}

	public function project ()
	{
		return $this->belongsTo(Project::class);
	}
}
