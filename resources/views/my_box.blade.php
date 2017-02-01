@extends('layouts.master')

@section('content')
<main flex>
	<h1>Your Box</h1>
	@foreach (Auth::user()->getFriends() as $friend)
		<h3>
			<li ng-controller="rateCtrl" ng-click="rate($event, {{$friend->id}})">
				<img src="{{$friend->getAvatar()}}" width="200px" height="200px" style="border-radius: 50%">
				{{$friend->fname . ' ' . $friend->lname}}
			</li>
		</h3>
	@endforeach
	<hr>
	<h1>Current Requests</h1>
	@foreach (Auth::user()->getFriendRequests() as $friend_request)
		<h3>
			<li ng-controller="boxCtrl">
				{{$user->find($friend_request->sender_id)->fname . ' ' .$user->find($friend_request->sender_id)->lname}}
				(<span ng-click="acceptFriendRequest({{$friend_request->sender_id}})">Accept</span> / 
				 <span ng-click="denyFriendRequest({{$friend_request->sender_id}})">Deny</span>)
			</li>
		</h3>
	@endforeach
</main>
@stop

