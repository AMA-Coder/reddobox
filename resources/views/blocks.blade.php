@extends('layouts.master')

@section('content')
	{{-- expr --}}

	<center>
		<p>
			<h1>Your block list</h1>
		</p>
		<p>
			@if (count(Auth::user()->getBlockedFriendships()) > 0)
				{{-- expr --}}
				<div class="row" style="min-height: 60%">
					@foreach (Auth::user()->getBlockedFriendships() as $blocked)
			      		<div class="col-sm-6 col-md-3 my friends">
							<div class="thumbnail" ng-controller="boxCtrl">
								<img width="200px" src="{{secure_url('uploads/images/')}}/{{$user->find($blocked->recipient_id)->avatar}}" >
				                  <div class="caption">
									<h4><a href="/profile/{{$blocked->recipient_id}}">{{$user->find($blocked->recipient_id)->fname . ' ' .$user->find($blocked->recipient_id)->lname}}</a></h4>
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@else
					<p>You haven't blocked anyone.</p>
				<div class="row" style="min-height: 60%">
				</div>
			@endif
		</p>
	</center>
@stop