<html lang="en" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Angular Material style sheet -->
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
		<link rel="stylesheet" type="text/css" href="{{secure_url('css/bootstrap.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{secure_url('css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{secure_url('css/style.css')}}">
		<LINK REL="SHORTCUT ICON" HREF="{{secure_url('images/icon.ico')}}">
		<title>Reddo-box</title>
	</head>
	<!-- Angular Material requires Angular.js Libraries -->
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/svg-assets-cache.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="{{secure_url('js/bootstrap.min.js')}}"></script>
    <script src="//rawgit.com/lugolabs/circles/master/circles.js"></script>
    <script src="//rawgit.com/ActivKonnect/angular-circles/master/angular-circles.js"></script>


  <script src=" {{secure_url('/js/ngFacebook.js')}} "></script>
  <!-- Angular Material Library -->
  <script src="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.1/angular-material.js"></script>
  <script src="{{secure_url('/js/app.js')}}"></script>
  <script src="{{secure_url('/js/angular-filter.min.js')}}"></script>
  <script type="text/javascript" src="{{secure_url('js/profileCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{secure_url('js/boxCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{secure_url('js/rateCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{secure_url('js/professionalCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{secure_url('js/notificationCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{secure_url('js/accountCtrl.js')}}" ></script>

  <script type="text/javascript" src="{{secure_url('extensions/notifications/angular-ui-notification.min.js')}}" ></script>
  <link rel="stylesheet" href="{{secure_url('extensions/notifications/angular-ui-notification.min.css')}}">

  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href=" {{secure_url('extensions/swal/sweetalert.css')}} ">
  <script type="text/javascript" src="{{secure_url('extensions/swal/sweetalert.min.js')}}" ></script>
<script type="text/javascript">
	app.controller('inviteCtrl', function ($scope, $https) {
		$scope.friends = JSON.parse('{!! json_encode(Auth::user()->getFriends()) !!}');
		console.log($scope.friends)
		console.log('a')
		$scope.inviteToggle = function (id) {
			$http.post('/invite/toggle/' + id, {
				projectID: {{$project->id}},
			})
		}

		$scope.$watch('search', function () {
		  $scope.r = $scope.search;
		  $http.post('/get/uninvited/users', {
		    'search': $scope.search,
		    'project_id': {!! $project->id !!}
		  }).then(function (result) {
		    setTimeout(function() {
		      if(result.data.users.length > 0) {
		        $scope.results = result.data.users;
		        $scope.$apply();
		      }else{
		        $scope.results = false;
		      }
		      console.log(result)
		    }, 0);
		  })
		})

	})
</script>
</head>
<div ng-app="BlankApp" ng-controller="inviteCtrl" class="container">
<button type="button" style="float: right; margin-top: 4vh" class="btn btn-default" onclick="window.close()">Done</button>
<h3>Friends you invited</h3>
	@if (count(Auth::user()->invitings($project->id)) == 0)
		<p>You haven't invited anyone yet.</p>
	@else
		@foreach (Auth::user()->invitings($project->id) as $friend)
			{{$friend->fname . ' ' . $friend->lname}}
			<input type="checkbox" checked value="{{$friend->id}}" ng-click="inviteToggle({{$friend->id}})">
		@endforeach
	@endif
	<hr>
<h3>Invite people</h3>
	@if (count(Auth::user()->getFriends()) == 0)
		<p>You have no friends yet.</p>
	@endif
		{{-- {{$friend->fname . ' ' . $friend->lname}}
		<input type="checkbox" value="{{$friend->id}}" ng-click="inviteToggle({{$friend->id}})"> --}}
		<div ng-repeat="friend in users | filter:searchText">
			@{{friend.fname}} @{{friend.lname}}
			<input type="checkbox" value="@{{friend.id}}" ng-click="inviteToggle(friend.id)">
		</div>
		<div>
			<form id="searchForm" action="#" ng-submit="$event.preventdefault()">
			  <input type="search" ng-model="search" placeholder="Find people to Reddo" class="form-control" >
			</form>
			<div ng-show="search" class="panel panel-default">
			<md-progress-linear ng-show="!results" md-mode="indeterminate"></md-progress-linear>
				<div class="panel-body">
					<div ng-show="results.length" ng-repeat="user in results">
						@if (!Auth::user()->invited('@{{user.id}}', $project->id))
							@{{user.full_name}} 
							<input type="checkbox" value="@{{user.id}}" ng-click="inviteToggle(user.id)">
						@endif
					</div>
					<div ng-show="!results">
						No results were found for "@{{r}}".
					</div>
				</div>
			</div>
		</div>
	<br>
</div>

