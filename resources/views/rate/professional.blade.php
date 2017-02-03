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
								<h3>{{$project->title}} ({{$project->type}})</h3>
								<h4>{{$project->description}}</h4>
							@if (Auth::id() == $id)
								<h4><a class="btn btn-default" onclick='window.open("/invite/{{$project->id}}", "", "width=330, height=500");'>Add people to this project</a></h4>
							@else
								<h4><a class="btn btn-default" data-toggle="modal" href='#rate-modal-{{$project->id}}'>Rate this project</a></h4>
								<div class="modal fade" id="rate-modal-{{$project->id}}">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
												<h3 class="modal-title">Rate the project ({{$project->title}})</h3>
											</div>
											<div class="modal-body">
											<p><h3>How do you rate this {{$project->type}}?</h3></p>
										      <md-slider-container>
										        <md-icon md-svg-icon="device:brightness-low"></md-icon>
										        <md-slider ng-model="rateModel[{{$project->id}}].rate"></md-slider>
										      </md-slider-container>
										      <hr>
											<p><h3>Write a short review about {{$project->title}}</h3></p>
											<br>
										      <textarea class="form-control" rows="6" required="required" ng-model="rateModel[{{$project->id}}].review"></textarea>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
												<button type="button" class="btn bg" ng-disabled="!rateModel[{{$project->id}}].review" ng-click="Rate({{$id}}, {{$project->id}}, rateModel[{{$project->id}}].rate, rateModel[{{$project->id}}].review)">Save changes</button>
											</div>
										</div>
									</div>
								</div>
							@endif
							</div>
							</center>
						</div>
					@endif
				@endforeach
			</div>
		</div>
	</div>
	<div class="modal fade" id="modal-id">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Invite friends</h4>
				</div>
				<div class="modal-body">
		             	<div ng-controller="inviteCtrl" ng-repeat="friend in friends">
		             		@{{friend.fname + ' ' + friend.lname}}
		             		<input type="checkbox" value="friend.id" ng-checked="checkIfInvited(friend.id)" ng-click="inviteToggle(friend.id)">
		             		<br>
		             	</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>
@stop