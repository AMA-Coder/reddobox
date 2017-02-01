<html lang="en" >
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Angular Material style sheet -->
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
    <link href="{{url('css/app.css')}}" rel="stylesheet">
    <link href="{{url('css/style.css')}}" rel="stylesheet">
    <title>Reddo-box</title>
</head>  <!-- Angular Material requires Angular.js Libraries -->
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script src=" {{url('/js/ngFacebook.js')}} "></script>
  <!-- Angular Material Library -->
  <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
  <script src="{{url('/js/app.js')}}"></script>
  <script type="text/javascript" src="{{url('js/profileCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/boxCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/rateCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/professionalCtrl.js')}}" ></script>
  <script type="text/javascript" src="{{url('js/notificationCtrl.js')}}" ></script>

  <script type="text/javascript" src="{{url('extensions/notifications/angular-ui-notification.min.js')}}" ></script>
  <link rel="stylesheet" href="{{url('extensions/notifications/angular-ui-notification.min.css')}}">

  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href=" {{url('extensions/swal/sweetalert.css')}} ">
  <script type="text/javascript" src="{{url('extensions/swal/sweetalert.min.js')}}" ></script>

<body ng-app="BlankApp" layout-fill layout="column" ng-cloak>
  <!--
    Your HTML content here
  -->  
@if (Auth::user())
  {{-- expr --}}
  {{Auth::user()->getNotifications()}}
@endif
@if (notify()->ready())
  <script type="text/javascript">
    var text = "{!! notify()->message() !!}"
  </script>
  <div ng-controller="notificationCtrl">
    

  </div>
@endif

  <!-- Your application bootstrap  -->
    <header>
      <md-toolbar class="md-menu-toolbar" style="background-color:#004040; color: white; height: 15vh">
        <div layout="row">
          <md-toolbar-filler layout layout-align="center center" style="width: 30%; background-color:#004040;">
            <h1>
            Reddo-box
            <md-tooltip md-direction="bottom">
                Welcome to Reddo-Box!
            </md-tooltip>
            </h1>
          </md-toolbar-filler>
          @yield('header')
            @if (Auth::user())
              <p><a href="{{route('logout')}}">Logout</a></p> - 
              <p><a href="">Notifications</a></p> - 
              <p><a href="/my/box">Your box</a></p> - 
              <p><a href="/profile/{{Auth::id()}}">Profile</a></p> - 
              <p><a href="/dashboard">Home</a></p>
            @endif
      </md-toolbar>
    </header>
@yield('content')

<footer style="background-color: #004040; height: 30vh; color: white;">
    <div layout="row" layout-align="center center">
        <h2>Footer</h2>
    </div>
</footer>
</body>
</html>
@yield('scripts')