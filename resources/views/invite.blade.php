<html lang="en" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Angular Material style sheet -->
		<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
		<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('css/bootstrap-theme.min.css')}}">
		<link rel="stylesheet" type="text/css" href="{{url('css/style.css')}}">
		<LINK REL="SHORTCUT ICON" HREF="{{url('images/icon.ico')}}">
		<title>Reddo-box</title>
	</head>
	<!-- Angular Material requires Angular.js Libraries -->
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/svg-assets-cache.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="//rawgit.com/lugolabs/circles/master/circles.js"></script>
    <script src="//rawgit.com/ActivKonnect/angular-circles/master/angular-circles.js"></script>


  <script src=" {{url('/js/ngFacebook.js')}} "></script>
  <!-- Angular Material Library -->
  <script src="https://cdn.gitcdn.link/cdn/angular/bower-material/v1.1.1/angular-material.js"></script>
  <script src="{{url('/js/app.js')}}"></script>
  <script src="{{url('/js/angular-filter.min.js')}}"></script>
  <script type="text/javascript" src="{{url('js/profileCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/boxCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/rateCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/professionalCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/notificationCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/accountCtrl.js')}}" ></script>

  <script type="text/javascript" src="{{url('extensions/notifications/angular-ui-notification.min.js')}}" ></script>
  <link rel="stylesheet" href="{{url('extensions/notifications/angular-ui-notification.min.css')}}">

  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href=" {{url('extensions/swal/sweetalert.css')}} ">
  <script type="text/javascript" src="{{url('extensions/swal/sweetalert.min.js')}}" ></script>
<script type="text/javascript">
	app.controller('inviteCtrl', function ($scope, $http) {
		$scope.friends = JSON.parse('{!! json_encode(Auth::user()->getFriends()) !!}');
		console.log($scope.friends)
		console.log('a')
	$scope.inviteToggle = function (id) {
		$http.post('/invite/toggle/' + id, {
			projectID: {{$project->id}},
		})
	}
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
	@foreach ($users as $friend)
		@if (!Auth::user()->invited($friend->id, $project->id))
			{{$friend->fname . ' ' . $friend->lname}}
			<input type="checkbox" value="{{$friend->id}}" ng-click="inviteToggle({{$friend->id}})">
		<br>
		@endif
	@endforeach
</div>

