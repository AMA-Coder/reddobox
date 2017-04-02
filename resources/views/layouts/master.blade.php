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
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script type="text/javascript" src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/t-114/svg-assets-cache.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
  <script src="{{url('js/bootstrap.min.js')}}"></script>
    <script src="//rawgit.com/lugolabs/circles/master/circles.js"></script>
    <script src="//rawgit.com/ActivKonnect/angular-circles/master/angular-circles.js"></script>
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33979560-3', 'auto');
  ga('send', 'pageview');

</script>
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
  <script type="text/javascript" src="{{url('js/pwResetCtrl.js')}}" ></script>

  <script type="text/javascript" src="{{url('extensions/notifications/angular-ui-notification.min.js')}}" ></script>
  <link rel="stylesheet" href="{{url('extensions/notifications/angular-ui-notification.min.css')}}">

  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href=" {{url('extensions/swal/sweetalert.css')}} ">
  <script type="text/javascript" src="{{url('extensions/swal/sweetalert.min.js')}}" ></script>

	<link rel="stylesheet" type="text/css" href="{{url('css/ns-default.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{url('css/ns-style-growl.css')}}" />

	<script src="{{url('js/notificationFx.js')}}"></script>

	<!--Your HTML content here-->
	<body ng-app="BlankApp" layout-fill layout="column" ng-cloak ng-controller="notificationCtrl">

	@if (Auth::user())
	  {{-- expr --}}
	  {{Auth::user()->getNotifications()}}
	@endif

@if (notify()->ready())
{{-- 	<script type="text/javascript">
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
    

  </div> --}}

<script>
(function() {

	app.controller('notifyCtrl', function ($scope, $http, $window) {

		$scope.seeNow = function() {
			$http.post('/readNotification', {
				id: "{!! notify()->option('id') !!}",
			}).then(function () {
				$window.location.href = "{!! url(notify()->option('url')) !!}";
			})
		}

		$scope.later = function () {
			$http.post('/laterNotification', {
				id: "{!! notify()->option('id') !!}",
			}).then(function () {

			})
		}
	})
// create the notification
var notification = new NotificationFx({
	wrapper : document.body,
	message : `
		<center ng-controller="notifyCtrl">
			<p>{!! notify()->message() !!}</p><br>
		<button type="button" class="btn" id="ns-close" style="background-color: lightgrey; color: #555" ng-click="later()">Later</button>
		<button type="button" class="btn" style="background-color: lightgrey; color: #555" ng-click="seeNow()">See now</button>
		</center>
	`,
	layout : 'growl',
	effect : 'slide',
	type : 'notice',
	ttl : 6000,

	// callbacks
	onClose : function() { return false; },
	onOpen : function() { return false; }

});

// show the notification
notification.show();
	})();

</script>

@endif


		<div class="container-fluid"> <!-- container of everything-->
		<nav class="navbar navbar-default"><div class="container">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/dashboard"><img src="/images/logo.png"></a>
				

			</div>
			<!-- Collect the nav links, forms, and other content for toggling -->
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				 <ul class="nav navbar-nav navbar-right">
				 	<li>{{-- <a href="/profile/{{Auth::id()}}">{{Auth::user()->fname}} {{Auth::user()->lname}}</a> --}}
				<a href="/dashboard">{{Auth::user()->fname}}</a></li>
				<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Notifications </span><span class="caret"></span>  <span class="label label-pill label-warning bg">@{{notes.length}}</span></a>
						<ul style="width: 160%" class="dropdown-menu">
							<div ng-repeat="note in notes | unique:'text' | limitTo:limit">
								<li><p style="padding: 10px" ng-click="read(note.text, note.url)"> @{{note.text}}
									<span class="label label-pill label-warning bg">
										@{{getCount(note.text)}}
									</span> 
									<br>
									<br>
								<span style="color: grey; font-size: 70%;"> @{{note.updated_at_humans}}</span>
								</p>
								</li>
								{{-- <li role="separator" class="divider" style="position: absolute;"></li> --}}
							</div>
							<div ng-show="notes.length && !noMore">
								<button style="width: 100%" type="button" class="btn btn-default" ng-click="showMore($event)">Show More</button>
							</div>
							<div ng-show="noMore">
								<center>
									<p style="padding: 20px">No more to load.</p>
								</center>
							</div>
							<div ng-show="!notes.length">
								<p style="padding: 20px">You have no new notifications.</p>
							</div>
						</ul>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-cog"></span><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="/profile/{{Auth::id()}}" >My Profile</a></li>
							{{-- <li><a href="/rate/professional/{{Auth::id()}}" >Professional box</a></li> --}}
							<li><a href="/blocks/{{Auth::id()}}" >Block List</a></li>
							{{-- <li><a href="/profile/{{Auth::id()}}">Account settings</a></li> --}}
							<li role="separator" class="divider"></li>
							<li><a href="/logout"> Logout </a></li>
						</ul>
					</li>
				 </ul>
				</div><!-- /.navbar-collapse --></div>
			</nav>
				{{-- <md-progress-linear style="position: absolute; top: 55px;" ng-controller="loadingCtrl" ng-show="loading" md-mode="indeterminate"></md-progress-linear> --}}
			<!--md-mode	can be select from one of four modes: determinate, indeterminate, buffer or query..-->
			</div>
			<div>
					@yield('content')
				</div>
		</body>
	</body>
    <div id="footer">
    <div class="row" style="margin: 0px;">
    	<div class="col-sm-7 footer-brand"><img src="/images/logo negative.png"></div>
    	<div class="col-sm-3"  style="text-align: center;">
	    	<a data-toggle="modal" href='#terms'>
		        <h3 class="footer-link">Terms and conditions</h3>
			</a>
		</div>
    	<div class="col-sm-2"  style="text-align: center;"><a data-toggle="modal" href='#contact-us'>
        <h3 class="footer-link">Contact us</h3>
      </a></div>
    </div>
</html>

<div class="modal fade" id="contact-us">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg color">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Contact us</h4>
			</div>
			<div class="modal-body" style="font-family: mynexa">
				<h1><span style="color: grey">Contact us at:</span> <br><center><span style="color: grey">Support@reddobox.com</span></center></h1>
			</div>
			<div class="modal-footer bg color">
			<br><br>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="terms">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header bg color">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Terms and conditions</h4>
			</div>
			<div class="modal-body" style="font-family: mynexa">
<b>Welcome to Reddobox.com</b> <br><br>

<p>
	Thank you for using our service. Reddobox.com is a startup created by a group of engineering students who aim providing a new service to the world in the social networking filed. We started building the website October 2016 and we will continue to develop it to match our users’ needs. Reddobox.com is located in Egypt - 6th of October City - Giza. 
	By using our Services, you are agreeing to the following terms. Please read it carefully.
	Reddobox.com terms of service
</p>
<br>
<p>
	This statement includes our terms of service that governs the relationship between our users and Reddobox.com. By accessing, registering and/or continuing to use Reddox.com Services, you agree to this Statement with immediate effect.
</p>
<hr>
<p>
	1- Reddobox.com will not share any of your passwords with any third parties (unless you authorize us to do so).
	<br><br>2- The security of your account is our priority. We don’t recommend you share your passwords with others as it might affect account security.
	<br><br>3- Your anonymous features will stay anonymous unless you share your information with people.
	<br><br>4- Reddobox.com does not have any official mobile apps in the meantime. Any app with similar names is not related to Reddobox.com.
	<br><br>5- Any account with false personal information might be blocked or suspended until further notice.
	<br><br>6- Reddobox.com might use your information to help you see relative content.
	<br><br>7- The upcoming updates in Reddobox.com might change those terms. 
	8- Last updated version of this document at 7th of March 2017.
</p>
			</div>
			<div class="modal-footer bg color">
			<br><br>
			</div>
		</div>
	</div>
</div>