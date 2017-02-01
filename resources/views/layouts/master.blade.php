<html lang="en" >
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Angular Material style sheet -->
		<link rel="stylesheet" type="text/css" href="{{url('css/angular-material.css')}}">
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
	<!--Your HTML content here-->
	<body ng-app="BlankApp" layout-fill layout="column" ng-cloak>

	@if (Auth::user())
	  {{-- expr --}}
	  {{Auth::user()->getNotifications()}}
	@endif

@if (notify()->ready())
	<script type="text/javascript">
		app.controller('notifyCtrl', function (Notification, $http, $window) {
			swal({
			  title: "{!! notify()->message() !!}",
			  showCancelButton: true,
			  cancelButtonText: 'Later..',
			  confirmButtonText: 'See now!',
			  closeOnConfirm: false,
			  showLoaderOnConfirm: true,
			  animation: "slide-from-top"
			},
			function(isConfirm){
				if (isConfirm) {
					$http.post('/readNotification', {
						id: "{!! notify()->option('id') !!}",
					}).then(function () {
						$window.location.href = "{!! url(notify()->option('url')) !!}";
					})
				}else{
					$http.post('/laterNotification', {
						id: "{!! notify()->option('id') !!}",
					}).then(function () {

					})
				}
			});
		})
	</script>
  <div ng-controller="notifyCtrl">
    

  </div>
@endif

		<div class="container-fluid"> <!-- container of everything-->
		<nav class="navbar navbar-default">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/dashboard"><img src="/images/logo.png"></a>
				<p class="navbar-text">
{{-- <a href="/profile/{{Auth::id()}}">{{Auth::user()->fname}} {{Auth::user()->lname}}</a> --}}
				<a href="/profile/{{Auth::id()}}">{{Auth::user()->fname}} {{Auth::user()->lname}}</a></p>
			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li class="dropdown" ng-controller="notificationCtrl">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notifications </span><span class="caret"></span>  <span class="label label-pill label-warning">@{{x}}</span></a>
						<ul style="width: 160%" class="dropdown-menu">
							<div ng-repeat="note in notes | unique:'text'">
								<li><p style="padding: 10px" ng-click="read(note.text, note.url)"> @{{note.text}}
									<span class="label label-pill label-warning">
										@{{getCount(note.text)}}
									</span>
								</p></li>
								<li role="separator" class="divider"></li>
							</div>
							<div ng-show="!haveNotifications">
								<p style="padding: 20px">You have no new notifications.</p>
							</div>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="/rate/professional/{{Auth::id()}}" >Professional box</a></li>
							<li><a href="/blocks/{{Auth::id()}}" >Block List</a></li>
							<li><a href="/profile/{{Auth::id()}}">Account settings</a></li>
							<li role="separator" class="divider"></li>
							<li><a href="/logout"> Logout </a></li>
						</ul>
					</li>
				</ul>
				</div><!-- /.navbar-collapse -->
			</nav>

				@yield('content')
			</div>
		</body>
	</body>
    <div id="footer">
      <img src="/images/logo negative.png">
      <a href="">
        <h3>FAQs</h3>
      </a>
      <a href="">
        <h3 style="margin-right:1vw;">Contact US |</h3>
      </a>
    
      
    </div>
</html>