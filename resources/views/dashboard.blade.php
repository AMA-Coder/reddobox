@extends('layouts.master')
@section('content')
      <div id="profilecontent" ng-controller="dashController"  style="min-height: 580px;">
        <div class="container"><div class="row" style="margin:0px;">
          <div class="col-md-3 col-sm-5">
            <div class="thumbnail">
					<div class="image-upload">
						<center>
						    <label class="profile-picture" for="file-input">
							<form enctype="multipart/form-data" method="post" action="/profile/{{Auth::id()}}" id="form">
							<div class="image-container">
							<img src="{{secure_url('uploads/images/' . Auth::user()->avatar)}}" width="100%" class="image">
							  <div class="overlay bg">
							    <div class="text">Click to change</div>
							  </div>
							</div>

						    <input type="file" id="file-input" name="image" onchange="document.getElementById('form').submit()" style="display: none;">

							{{csrf_field()}}
							</form>
						</center>
					</div>
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
		          <p><div ng-controller="showRatesCtrl">
			          <div class="row">
				          <div class="col-xs-12">
					          <a href="#" ng-click="read('Someone rated you personally!', '/rate/details?cat=personal')">
						        <center><h5><i class="fa fa-user"></i> Personal <span ng-show="personalNotes.length" class="badge color" style="background: red !important; margin-left: 5px">@{{personalNotes.length}}</span></h5></center>
						      </a>
		                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
		                    <div style="margin-top: -10px; height: 10px;" ng-style="personalStyles" class="bg"></div>
		                    <center>@{{personals}}%</center>
				          </div>
			          </div>
			          <br>
			          <div class="row">			          	
				          <div class="col-xs-12">
					          <a href="#" ng-click="read('Someone rated you socially!', '/rate/details?cat=social')">
						        <center><h5><i class="fa fa-user"></i> Social <span ng-show="socialNotes.length" class="badge color" style="background: red !important; margin-left: 5px">@{{socialNotes.length}}</span></h5></center>
					          </a>
		                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
		                    <div style="margin-top: -10px; height: 10px;" ng-style="socialStyles" class="bg"></div>
		                    <center>@{{socials}}%</center>
				          </div>
			          </div>
		          </div></p>
          <script type="text/javascript">
          	app.controller('showRatesCtrl', function ($scope, $http) {

          		$scope.colors = ['lightgrey', '#1D7F8D']

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
          			$scope.socials = $scope.socials || 0;
          			$scope.socialStyles = {
						width: $scope.socials + '%',
          			}


          			var personals = result.data.personals;
          			var personal_filtered = [];
          			for (var i = personals.length - 1; i >= 0; i--) {
          				if(personals[i].rate != 0) {
          					personal_filtered.push(personals[i]);
          				}
          			}
          			var personal_sum = 0;
          			for (var i = 0; i < personal_filtered.length; i++) {
          				personal_sum += personal_filtered[i].rate;
          			}
          			$scope.personals = Math.round(personal_sum/(personal_filtered.length));
          			$scope.personals = $scope.personals || 0;
          			$scope.personalStyles = {
						width: $scope.personals + '%',
          			}
          		})
          	})
          </script>

 				</div>
            </div>
          </div>
          
          
          
          
	          <div class="col-md-9 col-sm-7" style=" height: auto;">
		          <form id="searchForm" action="#" ng-submit="$event.preventdefault()">
			          <input type="search" ng-model="search" placeholder="Find people to Reddo" class="form-control" >
			      </form>
			      <div ng-show="search" class="panel panel-default">
				  <md-progress-linear ng-show="!results" md-mode="indeterminate"></md-progress-linear>
			      	<div class="panel-body">
			      		<div ng-show="results.length" ng-repeat="user in results">
			      			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			      				<a href="/profile/@{{user.id}}" class="thumbnail">
			      					<img width="150px" ng-src="{{secure_url('uploads/images/')}}/@{{user.avatar}}" alt="">
			      				</a>
			      					<center><p> @{{user.fname}} @{{user.lname}} </p></center>
			      			</div>
			      		</div>
			      		<div ng-show="!results">
			      			Searching for "@{{r}}".
			      		</div>
			      	</div>
			      </div>
			      
			      		<hr>
			      		<div class="row">
			      		<div ng-show="!friends.length">
			      			<p>You have no friends, yet.</p>
			      		</div>
			      		<div ng-show="friends.length">
			      			<p>Your friends</p>
			              <div class="col-sm-6 col-md-3 my friends" ng-repeat="friend in friends">
			                <div class="thumbnail">
			                  <img width="200px" ng-src="{{secure_url('uploads/images/')}}/@{{friend.avatar}}" >
			                  <div class="caption">
				                  <center>
				                    <h4 style="font-size: 100%; white-space: nowrap; overflow:hidden !important; text-overflow: ellipsis;"><a href="/profile/@{{friend.id}}">@{{friend.fname}} @{{friend.lname}}</a></h4>
				                  </center>
			                  </div>
			                </div>
			              </div>
			      		</div></div>
			      		<div class="row">
		          <div class="col-md-9">
		          <div class="col-sm-6 col-md-4"></div>
			      		<hr width="100%">
							<p>Current Requests</p>
							@if (count(Auth::user()->getFriendRequests()) == 0)
								<p>You don't have any friends requests currently.</p>
							@endif
							@foreach (Auth::user()->getFriendRequests() as $friend_request)
					      		<div class="col-sm-6 col-md-3 my friends">
									<div class="thumbnail" ng-controller="boxCtrl">
										<img width="200px" src="{{secure_url('uploads/images/')}}/{{$user->find($friend_request->sender_id)->avatar}}" >
						                  <div class="caption">
											<h4 style=" text-align: center; "><a href="/profile/{{$friend_request->sender_id}}">{{$user->find($friend_request->sender_id)->fname . ' ' .$user->find($friend_request->sender_id)->lname}}</a></h4>
											<p style=" text-align: center; "><a class="btn btn-default" ng-click="acceptFriendRequest({{$friend_request->sender_id}},{{Auth::id()}}, '{{Auth::user()->fname}}', '{{Auth::user()->lname}}')">Accept</a>
											 <a class="btn btn-default" ng-click="denyFriendRequest({{$friend_request->sender_id}})">Deny</a> </p>
										</div>
									</div>
								</div>
							@endforeach
			      		</div>
			      	</div>
			      		
	          </div>
	          
	          </div></div>
          </div>
        </div>
        </div><!-- /.container-fluid -->
      </div>

      <script type="text/javascript">
      	var id = {{Auth::id()}};
      </script>

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

