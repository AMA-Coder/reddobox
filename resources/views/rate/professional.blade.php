@extends('layouts.master')
@section('content')
	<div ng-controller="professionalCtrl">
		<div class="col-sm-6 col-md-3 my">
		    <div class="thumbnail">
		      <img src="{{url('uploads/images/' . $user->find($id)->avatar)}}" width="250px" alt="...">
	          <div class="caption">
	            <center><h3>{{$user->find($id)->fname}} {{$user->find($id)->lname}}</h3>
				@if (Auth::id() == $id)
					<a class="btn btn-default" ng-click="showPrompt($event, '{{route("new_project", $id)}}')">New Project</a>
				@endif
				</center>
	          </div>
			</div>
		</div>
		<div class="row">
			<div style="min-height: 70%">
				@if (count($user->find($id)->projects) == 0)
					<center style="height: 70%">
						<h1>There is no projects.</h1>
					</center>
				@endif
				@foreach ($user->find($id)->projects as $project)
					@if ($user->find($id)->invited(Auth::id(), $project->id) || $id == Auth::id())
						<div class="col-sm-6 col-md-3 my friends" ng-controller="projectCtrl">
							<center>
							<div class="thumbnail">
								<h3><a href="/rate/project/{{$project->id}}">{{$project->title}} ({{$project->type}})</a></h3>
								<h4>{{$project->description}}</h4>
							@if (Auth::id() == $id)
								<h4><a class="btn btn-default" onclick='window.open("/invite/{{$project->id}}", "", "width=330, height=500");'>Add people to this project</a></h4>
							@else
								<h4><a onclick="window.location='/rate/project/{{$project->id}}'" class="btn btn-default">Rate this project</a></h4>
							@endif
							</div>
							</center>
						</div>
					@endif
				@endforeach
				<div class="col-md-12">
					@if (count($invitations) > 0)
						<center>
							<h2>Projects you were invited it: </h2>
						</center>
					@endif
					@if ($id == Auth::id())
						@foreach ($invitations as $invitation)
							<div class="col-sm-6 col-md-3 my friends" ng-controller="projectCtrl">
								<center>
								<div class="thumbnail">
									<h3><a href="/rate/project/{{$invitation->project->id}}">{{$invitation->project->title}}</a> By <a href="/profile/{{$invitation->fromUser->id}}">{{$invitation->fromUser->full_name}}</a></h3>
									<h4>{{$invitation->project->description}}</h4>
									<h4><a onclick="window.location='/rate/project/{{$invitation->project->id}}'" class="btn btn-default">Rate</a></h4>
								</div>
								</center>
							</div>
						@endforeach
					@endif
				</div>
			</div>
		</div>
	</div>
@stop