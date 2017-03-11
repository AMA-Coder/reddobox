@extends('layouts.master')
@section('content')
<div class="container"   style="min-height: 580px;">
        <div class="row">
          <div class="col-md-3 col-sm-4">
            <div class="thumbnail">
            	@if (Auth::id() == $user->id)
					<div class="image-upload">
						<center>
						    <label for="file-input">
							<form enctype="multipart/form-data" method="post" action="" id="form">
							<div class="image-container">
							<img src="{{url('uploads/images/' . Auth::user()->avatar)}}" width="100%" class="image">
							  <div class="overlay bg">
							    <div class="text">Click to change</div>
							  </div>
							</div>

						    <input type="file" id="file-input" name="image" onchange="document.getElementById('form').submit()" style="display: none;">

							{{csrf_field()}}
							</form>
						</center>
					</div>
					
				        
            	@else
	              <img src="{{url('uploads/images/' . $user->avatar)}}" width="250px" alt="...">
            	@endif
              <div class="caption">
                <center><h3>{{$user->fname}} {{$user->lname}}</h3></center>
                {{-- <p>Short description</p> --}}
                <center>
                @if ( Auth::id() != $user->id)
					<div ng-controller="profileCtrl">
						@if (Auth::user()->hasBlocked($user))
							<h1>You Blocked {{$user->gender == 'male' ? 'him' : 'her'}}</h1>
							<button class="btn btn-default" ng-click="unblock({{$user->id}})">Unblock</button>
						@elseif (Auth::user()->isBlockedBy($user))
							<h1>This user BLOCKED YOU</h1>
						@else
							<div ng-show="!isFriend && !hasFriendRequestFrom">
								<button class="btn btn-default" ng-show="!hasSentRequest" ng-click="sendRequest({{$user->id}}, {{Auth::id()}})">Add to your box</button>
								<button class="btn btn-default" ng-show="hasSentRequest" ng-click="removeRequest({{$user->id}})">Remove request</button>
								<button class="btn btn-default" ng-click="block({{$user->id}})">Block</button>
							</div>
							<div ng-show="hasFriendRequestFrom">
								<button class="btn btn-default" ng-click="acceptFriendRequest({{$user->id}}, {{Auth::id()}}, '{{Auth::user()->fname}}', '{{Auth::user()->lname}}')">Accept friend request</button>
								<button class="btn btn-default" ng-click="block({{$user->id}})">Block</button>
							</div>
							<div ng-show="isFriend">
								<p>You are friends</p>
								<button class="btn btn-default" ng-click="removeRequest({{$user->id}})">Unfriend</button>
							</div>
							@endif
					</div>
				@endif
				</center>
              </div>
{{-- 		          <div class="row" style="margin-bottom: 10px;color: rgb(102, 102, 102)">
		          	<div class="col-md-12" style=" height: auto;" ng-controller="showRatesCtrl">
			          <div class="col-xs-6">
				          <center><h4><i class="fa fa-users"></i><br>Social</h4></center>
					        <div style="width: 100%" ng-circles colors="colors" value="socials" class="circle"></div>					          	
			          </div>
			          <div class="col-xs-6">
				          <center><h4><i class="fa fa-user"></i><br>Personal</h4></center>
					        <div style="width: 100%" ng-circles colors="colors" value="personals" class="circle"></div>					          	
			          </div>
		          </div>
		          </div>
 --}}            </div>
          </div>
		@if ( Auth::id() == $user->id)
			<center>
				<!-- Current User -->
				<script type="text/javascript">
					var user = {
						email: '{{Auth::user()->email}}',
						fname: '{{Auth::user()->fname}}',
						lname: '{{Auth::user()->lname}}',
						gender: '{{Auth::user()->gender}}',
						dof: '{{Auth::user()->dof}}',
					}
				</script>
				<div ng-controller="accountCtrl">
				    <md-dialog-content>
				      <div class="md-dialog-content">
				          <md-content layout-padding>
				            <form name="projectForm">

				              <md-input-container class="md-block" flex="50">
				                <label>Email address</label>
				                <input ng-disabled="user.email" value="aa" minlength="6" maxlength="100" md-no-asterisk name="email" ng-model="user.email" ng-pattern="/^.+@.+\..+$/">
				                <div ng-messages="projectForm.email.$error">
				                  <div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
				                    Your email must be between 10 and 100 characters long and look like an e-mail address.
				                  </div>
				                </div>
				                <md-tooltip md-direction="bottom">
				                    Email adress
				                </md-tooltip>
				              </md-input-container>

				              <div layout="row">
				                <md-input-container class="center" flex="30">
				                  <label>First Name</label>
				                  <input md-maxlength="15" name="fname" ng-model="user.fname">
				                  <div ng-messages="projectForm.fname.$error">
				                    <div ng-message="md-maxlength">The name must be less than 15 characters long.</div>
				                  </div>
				                <md-tooltip md-direction="bottom">
				                    First Name
				                </md-tooltip>
				                </md-input-container>

				                <md-input-container class="center" flex="30">
				                  <label>Last Name</label>
				                  <input md-maxlength="15" name="lname" ng-model="user.lname">
				                  <div ng-messages="projectForm.lname.$error">
				                    <div ng-message="md-maxlength">The name must be less than 15 characters long.</div>
				                  </div>
				                <md-tooltip md-direction="bottom">
				                    Last Name
				                </md-tooltip>
				                </md-input-container>
				              </div>

				              <div layout="row">
						        <md-input-container class="center" flex="30">
									<label>Date of birth</label>
									<input name="dof" type="text" ng-model="user.dof" ng-change="con()" value="2015-11-30"
									ng-pattern="/^(0?[1-9]|[12][0-9]|3[01]|dd)-(0?[1-9]|1[012]|mm)-(yyyy|19\d\d|20[12]\d)$/">
				                <div ng-messages="projectForm.dof.$error">
				                  <div ng-message-exp="['pattern']">
				                    Enter your proper birth date.
				                  </div>
				                 </div>
						        </md-input-container>

				                <md-input-container class="center" flex="30">
				                  <label>Gender</label>
				                  <md-select name="type" ng-model="user.gender">
				                    <md-option value="male">Male</md-option>
				                    <md-option value="female">Female</md-option>
				                  </md-select>
				                <md-tooltip md-direction="bottom">
				                    Gender
				                </md-tooltip>
				                </md-input-container>
				              </div>
				               <md-dialog-actions layout="row">
				      <md-button type="submit" style="width: 100%" class="bg left" style="color:white;" ng-disabled="projectForm.$invalid" ng-click="edit({{Auth::id()}})">
				        Update info
				      </md-button>
				    </form>
				    </md-dialog-actions>
				  </md-content>
				      </div>
				     
				    </md-dialog-content>

				    
				</md-dialog>
				</div>
				<a class="btn bg color" data-toggle="modal" href='#modal-id' style="position: absolute; right: 33%;">Change your password</a>
				<div class="modal fade" id="modal-id">
					<div class="modal-dialog">
						<div class="modal-content" ng-controller="pwResetCtrl">
							<div class="modal-header bg color">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
								<h4 class="modal-title">Change your password</h4>
							</div>
							<div class="modal-body">
								
								<div class="form-group">
									<input type="password" class="form-control" ng-model="new_password" placeholder="Enter your new password..">
								</div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="button" class="btn bg color" ng-click="resetPassword()">Save changes</button>
							</div>
						</div>
					</div>
				</div>
			</center>
		@else
          <div class="col-md-9 col-sm-8" style="height: auto; padding-bottom: 30px" ng-controller="showRatesCtrl">
          <div class="row">
	          <div class="col-md-6 col-sm-6">
		          @if (Auth::user()->isFriendWith($user))
			          <center>
			          	<h2>
				          <a style="cursor: pointer; text-decoration: none" ng-click="personal({{$user->id}})">Personal</a>
				       	</h2>
				       </center>
		          @else
		          	<h2><center>Personal</center></h2>
		          @endif
			        <a style="cursor: pointer; text-decoration: none" ng-click="personal({{$user->id}})"><div ng-circles colors="colors" value="personals" class="circle"></div></a>		          	
	          </div>
	          <div class="col-md-6 col-sm-6">
		          @if (Auth::user()->isFriendWith($user))
			          <center>
			          	<h2>
				          <a style="cursor: pointer; text-decoration: none" ng-click="social({{$user->id}})">Social</a>
				       	</h2>
				      </center>
		          @else
		          	<h2><center>Social</center></h2>
		          @endif
			        <a style="cursor: pointer; text-decoration: none" ng-click="social({{$user->id}})"><div ng-circles colors="colors" value="socials" class="circle"></div></a>					          	
	          </div>
	          </div>
	          
	           <div ng-controller="dashController" class="row">
  		<center>
  			<h2 style="text-align: center;">People in
  			@if (Auth::id() == $user->id)
	  			your
  			@else
  				{{$user->gender == 'male' ? 'his' : 'her'}}
  			@endif
  			box
  			</h2>
	      		<div ng-show="!friends.length">
	      			<p>There is no people in the box.</p>
	      		</div>
          <div class="col-sm-4 col-md-3 my friends col-xs-12" ng-repeat="friend in friends">
            <div class="thumbnail">
              <img width="200px" src="{{url('uploads/images/')}}/@{{friend.avatar}}" >
              <div class="caption">
                <h4> <a href="/profile/@{{friend.id}}">@{{friend.fname}} @{{friend.lname}}</a> </h4>
               	
              </div>
            </div>
          </div>
         </center>
  		</div>
  		
	          @if (!Auth::user()->isFriendWith($user))
          	<div class="row"><center class="col-md-8">
          		<h2>You can't rate {{$user->gender == 'male' ? 'him' : 'her'}}, because {{$user->gender == 'male' ? 'he' : 'she'}}'s not in your box.</h2>
          	</center></div>

          @endif
          
         
          
          </div>
          
	  @endif
          <script type="text/javascript">
          	app.controller('showRatesCtrl', function ($scope, $http, $window) {

          		$scope.colors = ['lightgrey', '#1D7F8D']

				$scope.social = function (id) {
				  $window.location.href = '/rate/social/' + id;
				}
				$scope.personal = function (id) {
				  $window.location.href = '/rate/personal/' + id;
				}
				$scope.goProf = function (id) {
				  $window.location.href = '/rate/professional/' + id;
				}

          		$scope.socials = 0;
          		$scope.personals = 0;

          		$http.post('/get/rates', {
          			id: {{$user->id}}
          		}).then(function (result) {

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
          			console.log($scope.personals)

          		})
          	})
          </script>
		</div></div>
	<br>

  		<hr width="95%" align="center">
  		<br>
@stop
<script>
	var id = {{$user->id}};
</script>