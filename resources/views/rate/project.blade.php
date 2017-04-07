@extends('layouts.master')

@section('content')
	<div ng-controller="projectCtrl">
		<div class="col-sm-6 col-md-3 my">
		    <div class="thumbnail">
		      <img src="{{secure_url('uploads/images/' . $user->avatar)}}" width="250px" alt="...">
	          <div class="caption">
	            <center><h3>{{$user->fname}} {{$user->lname}}</h3>
				</center>
	          </div>
			</div>
		</div>
		<div class="col-sm-6 col-md-8">
			<div style="min-height: 70%">
				<center>
					<h3>{{$project->title}}</h3>
					<h4>By {{$user->full_name}}</h4>
				</center>
				<hr>
				<h4>{{$project->description}}</h3>
				<hr>
				</h4>
				@if ($project->user->id == Auth::id())
					<h3>Here's the rates on your {{$project->type}}</h3>

					@if (count($rates) > 0)
			            <div class="col-md-10 col-sm-10">
			            @foreach ($rates as $rate)
			              <div class="panel panel-default arrow left">
			                <div class="panel-body">
			                  <header class="text-left">
			                    <div class="comment-user"><b><a href="/profile/{{$rate->user->id}}">{{$rate->user->full_name}}</a></b></div>
			                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="glyphicon glyphicon-time"></i> {{$rate->updated_at->diffForHumans()}}</time>
			                  </header>
			                  <div class="comment-post">
			                  <br>
			                  <p>
			                    <b>{{$rate->user->fname}}'s</b> rate: {{$rate->rate}}%<br>
			                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
			                    <div style="margin-top: -10px; height: 10px; width: {{$rate->rate}}%;" class="bg"></div>
			                  </p>
			                    <p>
			                    <b>{{$rate->user->fname}}'s</b> review: <br>
			                    {{$rate->review}}
			                    </p>
			                  </div>
			                </div>
			              </div>
			            @endforeach
			            </div>
					@else
						<center><h3>No one rated/reviewed your {{$project->type}}, yet</h3></center>
					@endif

				@else
					@if ($user->invited(Auth::id(), $project->id))
						<p><h4>How do you rate this {{$project->type}}?</h4></p>
					      <md-slider-container>
					        <md-icon md-svg-icon="device:brightness-low"></md-icon>
					        <md-slider ng-model="rateModel.rate" md-discrete=""></md-slider>
					      </md-slider-container>
					      <hr>
						<p><h4>Write a short review about {{$project->title}}</h4></p>
						<br>
					      <textarea class="form-control" rows="6" required="required" ng-model="rateModel.review"></textarea>
					      <hr>
							<center>
								<button style="width: 50%" class="btn bg" ng-disabled="!rateModel.review" ng-click="Rate({{$user->id}}, {{$project->id}})">Save changes</button>
							</center>
						<hr>
					@else
						{{$a}}
					@endif
				@endif
			</div>
		</div>
	</div>
<script type="text/javascript">
	app.controller('projectCtrl', function ($scope, $http) {
	    $scope.rateModel = [];

	    var project_id = {{$project->id}};
	    var user_id = {{$user->id}};

		$http.post('/rate/professional/' + user_id + '/get_my_rate_on_a_project', {
			project_id: project_id
		}).then(function(res) {
			$scope.rateModel.rate = res.data.rate;
			$scope.rateModel.review = res.data.review;
		})

	    $scope.Rate = function (user_id, project_id) {
	      $http.post('/rate/professional/' + user_id + '/project/rate', {
	      	project_id: project_id,
	        rate: $scope.rateModel.rate,
	        review: $scope.rateModel.review,
	      }).then(function (result) {
	        if (result.data.check == true) {
	          swal('Done');
	        }else{
	          swal('Error');
	        }
	      });
	    }
	})
</script>
@stop