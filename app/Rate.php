<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\RateTrait;
use App\Chat;
use Auth;

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

	public function getChatsReddo ()
	{
		$chats1 = Chat::whereFromId($this->from_id)->whereToId($this->user_id)->where('anon_id', '=', Auth::id())->get();
		$chats2 = Chat::whereFromId($this->user_id)->whereToId($this->from_id)->where('anon_id', '=', Auth::id())->get();
		$chats = $chats1->merge($chats2);
		return $chats;
	}

	public function getChatsRecieved ()
	{
		$chats1 = Chat::whereFromId($this->from_id)->whereToId($this->user_id)->where('anon_id', '!=', Auth::id())->get();
		$chats2 = Chat::whereFromId($this->user_id)->whereToId($this->from_id)->where('anon_id', '!=', Auth::id())->get();
		$chats = $chats1->merge($chats2);
		return $chats;
	}
}
