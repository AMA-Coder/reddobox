<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = ['id'];

	public function user ()
	{
		return $this->belongsTo(User::class);
	}
	
	public function rates ()
	{
		return $this->hasMany(projectRate::class);
	}

	public function members ()
	{
		return $this->hasMany(projectMember::class);
	}
}