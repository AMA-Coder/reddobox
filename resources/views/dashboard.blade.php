@extends('layouts.master')
@section('content')
      <div id="profilecontent" ng-controller="dashController">
        <div class="row">
          <div class="col-sm-6 col-md-3 my">
            <div class="thumbnail">
	              <img src="{{url('uploads/images/')}}/{{Auth::user()->avatar}}" width="250px" alt="...">
              <div class="caption">
                <center><h3>{{Auth::user()->fname}} {{Auth::user()->lname}}</h3></center>
                {{-- <p>Short description</p> --}}
{{--                 @if (Auth::user()->provider_user_id == 0)
	                <p><md-button onclick="window.open('redirect')" md-no-ink class="md-raised md-primary" style="background-color:#18577a;" >Link your account to Facebook</md-button></p>
                @else
                	<center>
                		<p>(Linked with Facebook)</p>
                	</center>
                @endif
 --}}              
				<p>
					Your ratings
				</p>
		          <div class="col-md-12" style=" min-height: 80%;" ng-controller="showRatesCtrl">
			          <br>
			          <div style="float: left; clear: both; position: absolute;">
				          <center><h4>Social</h4></center>
					        <div style="width: 100px" ng-circles value="socials" class="circle"></div>
			          </div>
			          <div style="float: left; clear: both; position: absolute; right: 30px">
				          <center><h4>Personal</h4></center>
					        <div style="width: 100px" ng-circles value="personals" class="circle"></div>	
			          </div>				          	
		          </div>
          <script type="text/javascript">
          	app.controller('showRatesCtrl', function ($scope, $http) {

          		$scope.socials = 0;
          		$scope.personals = 0;

          		$http.post('/get/rates', {
          			id: {{Auth()->id()}}
          		}).then(function (result) {

          			console.log(result.data)
          			var socials = result.data.socials;
          			var social_filtered = [];
          			for (var i = socials.length - 1; i >= 0; i--) {
          				if(socials[i].rate != 0) {
          					social_filtered.push(socials[i]);
          				}
          			}
          			var social_sum = 0;
          			for (var i = 0; i < social_filtered.length; i++) {
          				social_sum += social_filtered[i].rate;
          			}
          			$scope.socials = Math.round(social_sum/(social_filtered.length));
          			console.log($scope.socials)

          			var personals = result.data.personals;
          			personal = 0;
          			for (var i = personals.length - 1; i >= 0; i--) {
          				var temp = personals[i].one + personals[i].two + personals[i].three;
          				personal = personal + temp;
          			}
          			$scope.personals = Math.round(personal*100/(personals.length*300));

          		})
          	})
          </script>

 				</div>
            </div>
          </div>
	          <div class="col-md-9" style=" height: auto;">
		          <form id="searchForm" action="#" ng-submit="$event.preventdefault()">
			          <input type="search" ng-model="search" placeholder="Find people to Reddo" class="form-control" >
			      </form>
			      <div ng-show="search" class="panel panel-default">
				  <md-progress-linear ng-show="!results" md-mode="indeterminate"></md-progress-linear>
			      	<div class="panel-body">
			      		<div ng-show="results.length" ng-repeat="user in results">
			      			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			      				<a href="/profile/@{{user.id}}" class="thumbnail">
			      					<img width="150px" src="{{url('uploads/images/')}}/@{{user.avatar}}" alt="">
			      				</a>
			      					<center><p> @{{user.fname}} @{{user.lname}} </p></center>
			      			</div>
			      		</div>
			      		<div ng-show="!results">
			      			No results were found for "@{{r}}".
			      		</div>
			      	</div>
			      </div>
			      		<hr>
			      		<div ng-show="!friends.length">
			      			<p>You have no friends, yet.</p>
			      		</div>
			      		<div ng-show="friends.length">
			      			<p>Your friends</p>
			              <div class="col-sm-6 col-md-3 my friends" ng-repeat="friend in friends">
			                <div class="thumbnail">
			                  <img width="200px" src="{{url('uploads/images/')}}/@{{friend.avatar}}" >
			                  <div class="caption">
			                    <h4> @{{friend.fname}} @{{friend.lname}} </h4>
			                    <p><a href="/profile/@{{friend.id}}" class="btn btn-default" role="button">Reddo @{{friend.fname}}</a></p>
			                  </div>
			                </div>
			              </div>
			      		</div>
	          </div>
	          <div class="row">
		          <div class="col-md-9">
		          <div class="col-sm-6 col-md-4"></div>
			      		<hr>
							<p>Current Requests</p>
							@if (count(Auth::user()->getFriendRequests()) == 0)
								<p>You don't have any friends requests currently.</p>
							@endif
							@foreach (Auth::user()->getFriendRequests() as $friend_request)
					      		<div class="col-sm-6 col-md-3 my friends">
									<div class="thumbnail" ng-controller="boxCtrl">
										<img width="200px" src="{{url('uploads/images/')}}/{{$user->find($friend_request->sender_id)->avatar}}" >
						                  <div class="caption">
											<h4><a href="/profile/{{$friend_request->sender_id}}">{{$user->find($friend_request->sender_id)->fname . ' ' .$user->find($friend_request->sender_id)->lname}}</a></h4>
											<p><a class="btn btn-default" ng-click="acceptFriendRequest({{$friend_request->sender_id}},{{Auth::id()}}, '{{Auth::user()->fname}}', '{{Auth::user()->lname}}')">Accept</a>
											 <a class="btn btn-default" ng-click="denyFriendRequest({{$friend_request->sender_id}})">Deny</a> </p>
										</div>
									</div>
								</div>
							@endforeach
			      		</div>
			      	</div>
	          </div>
          </div>
        </div>
        </div><!-- /.container-fluid -->
      </div>

{{-- 		<center>
		<div ng-controller="DemoBasicCtrl as ctrl">
			<a href="redirect"><md-button class="md-raised">
				FB
				<md-tooltip md-direction="bottom">
				Login with your account
				</md-tooltip>
			</md-button></a>
			<md-button ng-click="loginToggle()" class="md-raised">
				Fetch friends
			<md-tooltip md-direction="bottom">
				Fetch friends
			</md-tooltip>
			</md-button>
		</div>
		<span ng-if="status" class="message">
			You are <strong>Logged in</strong> as <em>@{{user.name}}</em>
		</span>
		<span ng-if="!status" class="message">
			You are <strong>not</strong> logged in.
		</span>
		<div>
			<h2>Friends:</h2>
		</div>
		<br><br><div ng-show="loading" layout="row" layout-sm="column" layout-align="space-around">
			<md-progress-circular md-mode="indeterminate"></md-progress-circular>
		</div><br><br>
		@if(count($friends>0))
			@foreach($friends as $friend)
				<div ng-controller="rateCtrl">
					<img ng-click="rate($event, {{$friend->id}} )" src="{{$friend->avatar}}" alt=""><br>
					<p>{{$friend->fname}} {{$friend->lname}}</p>
				</div>
			@endforeach
		@else
			<p>You have no common friends.</p>
		@endif

		<hr>

		<form method="get" action="">
			<input type="search" name="email" placeholder="Search by mail">
			<input type="submit">
			{{csrf_field()}}
		</form>
		<form method="get" action="">
			<input type="search" name="email" placeholder="Search by Facebook">
			<input type="submit">
			{{csrf_field()}}
		</form>
		@if ($result)
			<h3>
				<li>
					<a href="{{route('profileRoute', $result->id)}}">{{$result->fname}}</a> 
					@if (Auth::id() == $result->id)
						(YOU)
					@endif
				</li>
			</h3>
		@endif
		</center>
 --}}
 @stop

