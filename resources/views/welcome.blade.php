<html lang="en" >
<head>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Angular Material style sheet -->
  <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <LINK REL="SHORTCUT ICON" HREF="images/icon.ico">
  <title>Reddo-box</title>

</head>
 <!-- Angular Material requires Angular.js Libraries -->
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
  <script src=" {{url('/js/ngFacebook.js')}} "></script>
  <!-- Angular Material Library -->
  <script src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
  <script src="{{url('/js/app.js')}}"></script>
  <script src="{{url('/js/angular-filter.min.js')}}"></script>
    <script src="//rawgit.com/lugolabs/circles/master/circles.js"></script>
    <script src="//rawgit.com/ActivKonnect/angular-circles/master/angular-circles.js"></script>

  <script type="text/javascript" src="{{url('extensions/notifications/angular-ui-notification.min.js')}}" ></script>
  <link rel="stylesheet" href="{{url('extensions/notifications/angular-ui-notification.min.css')}}">

  <!-- sweet alert -->
  <link rel="stylesheet" type="text/css" href=" {{url('extensions/swal/sweetalert.css')}} ">
  <script type="text/javascript" src="{{url('extensions/swal/sweetalert.min.js')}}" ></script>

<body ng-app="BlankApp" layout-fill layout="column" ng-cloak> 
<!--Your HTML content here--> 
@if (isset($_GET['confirmed']) == 1)
  <script type="text/javascript">
    swal({title: 'Confirmed!'}, function () {
      window.location = '/';
    });
  </script>
@endif
  <div class="container" ng-controller="DemoBasicCtrl as ctrl"> <!-- container of everything-->

    <div id="cover"> <!-- container of the cover area-->
      <div id="logo">
        <img src="images/logo.png">
      </div>
      <div class="dialog-demo-content" style="margin-top: -100px" layout="row" layout-wrap layout-margin layout-align="margin-left">
        <md-button class="md-primary md-raised sign-up" ng-click="signupPrompt()">
            Sign up
        </md-button>
        <md-button class="md-primary md-raised sign-up" ng-click="loginPrompt()">
            Log in
        </md-button>
      </div>
    </div>
    <div id="middel">
      <div id="middelimg">
        <img src="images/image.png">
      </div>
      <div id="middeltxt">
          <h2>
            • Reddo Box is a social and professional web that helps you to
            know how others see you . You can Reddo others to share your
            opinion. <br><br><br><br>
            • The site will deliver your opinion anonymously <br><br><br><br>
            • You can create events, jobs, projects, or even a relationship to get
             feedback on.
          </h2>
      </div>
    </div>
    <div id="footer">
      <img src="images/logo negative.png">
      <a href="">
        <h3>FAQs</h3>
      </a>
      <a href="">
        <h3 style="margin-right:1vw;">Contact US |</h3>
      </a>
    
      
    </div>


      
  </div>
<script type="text/ng-template" id="signup.tmpl.html">
<md-dialog aria-label="Sign up" style="width:70%" ng-controller="userCtrl">
    <md-toolbar class="bg">
      <div class="md-toolbar-tools">
        <h2 class="bg">Sign up</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
          <md-icon md-svg-src="img/icons/ic_close_24px.svg" aria-label="Close dialog"></md-icon>
        </md-button>
      </div>
    </md-toolbar>

    <md-dialog-content>
      <div class="md-dialog-content">
          <md-content layout-padding>
            <form name="projectForm">

              <md-input-container class="md-block">
                <label>Email address</label>
                <input minlength="6" maxlength="100" required md-no-asterisk name="email" ng-model="user.email" ng-pattern="/^.+@.+\..+$/">
                <div ng-messages="projectForm.email.$error">
                  <div ng-message="required">This is required.</div>
                  <div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
                    Your email must be between 10 and 100 characters long and look like an e-mail address.
                  </div>
                </div>
                <md-tooltip md-direction="bottom">
                    Email adress
                </md-tooltip>
              </md-input-container>

              <div layout="row">
                <md-input-container flex="50">
                  <label>First Name</label>
                  <input md-maxlength="15" required name="fname" ng-model="user.fname">
                  <div ng-messages="projectForm.fname.$error">
                    <div ng-message="required">This is required.</div>
                    <div ng-message="md-maxlength">The name must be less than 15 characters long.</div>
                  </div>
                <md-tooltip md-direction="bottom">
                    First Name
                </md-tooltip>
                </md-input-container>

                <md-input-container flex="50">
                  <label>Last Name</label>
                  <input md-maxlength="15" required name="lname" ng-model="user.lname">
                  <div ng-messages="projectForm.lname.$error">
                    <div ng-message="required">This is required.</div>
                    <div ng-message="md-maxlength">The name must be less than 15 characters long.</div>
                  </div>
                <md-tooltip md-direction="bottom">
                    Last Name
                </md-tooltip>
                </md-input-container>
              </div>

              <div layout="row">
                <md-input-container flex="50">
                  <label>Date of birth</label>
                  <input required name="dof" type="date" ng-model="user.dof">
                  <div ng-messages="user.dof.$error">
                    <div ng-message="required">This is required.</div>
                  </div>
                <md-tooltip md-direction="bottom">
                    Date of birth
                </md-tooltip>
                </md-input-container>

                <md-input-container flex="50">
                  <label>Gender</label>
                  <md-select name="type" ng-model="user.gender" required>
                    <md-option value="male">Male</md-option>
                    <md-option value="female">Female</md-option>
                  </md-select>
                <md-tooltip md-direction="bottom">
                    Gender
                </md-tooltip>
                </md-input-container>
              </div>
              <md-input-container class="md-block">
                <label>Password</label>
                <input required type="password" name="password" ng-model="user.password"
                       minlength="6" maxlength="30"/>

                <div ng-messages="projectForm.password.$error" md-auto-hide="false" role="alert">
                  <div ng-message-exp="['required', 'minlength', 'maxlength']">
                    Your password must be between 6 and 30 characters long.
                  </div>
                </div>
                <md-tooltip md-direction="bottom">
                    Password
                </md-tooltip>
              </md-input-container>

              <md-input-container class="md-block">
                <label>Password Confirmation</label>
                <input required type="password" name="password_confirmation" ng-pattern="@{{user.password}}" ng-model="user.password_confirmation"/>

                <div ng-messages="projectForm.password_confirmation.$error" md-auto-hide="false" role="alert">
                    <div ng-message="pattern">The password doesn't match.</div>
                </div>
              </md-input-container>
          </md-content>
      </div>
    </md-dialog-content>

    <md-dialog-actions layout="row">
      <md-button type="submit" class="bg" style="color:white;" ng-disabled="projectForm.$invalid" ng-click="signup(user)">
        Register
      </md-button>
    </form>
    </md-dialog-actions>
</md-dialog>
</script>


<script type="text/ng-template" id="login.tmpl.html">
    <md-dialog aria-label="Log in" style="width:70%" ng-controller="userCtrl">
        <md-toolbar class="bg">
          <div class="md-toolbar-tools">
            <h2 class="bg">Log in</h2>
            <span flex></span>
          </div>
        </md-toolbar>

        <md-dialog-content>
          <div class="md-dialog-content">
              <md-content layout-padding>
                <form name="projectForm" method="post" id="projectForm" action="/auth">
                {{ csrf_field() }}
                  <md-input-container class="md-block">
                    <label>Email address</label>
                    <input minlength="6" maxlength="100" required md-no-asterisk name="email" ng-model="user.email" ng-pattern="/^.+@.+\..+$/">
                    <div ng-messages="projectForm.email.$error">
                      <div ng-message="required">This is required.</div>
                      <div ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
                        Your email must be between 10 and 100 characters long and look like an e-mail address.
                      </div>
                    </div>
                  </md-input-container>

                  <md-input-container class="md-block">
                    <label>Password</label>
                    <input required type="password" name="password" ng-model="user.password"
                           minlength="6" maxlength="30" ng-keypress="myFunct(user, $event)"/>

                    <div ng-messages="projectForm.password.$error" md-auto-hide="false" role="alert">
                      <div ng-message-exp="['required', 'minlength', 'maxlength']">
                        Your password must be between 6 and 30 characters long.
                      </div>
                    </div>
                  </md-input-container>
              </md-content>
          </div>
        </md-dialog-content>

        <md-dialog-actions layout="row">
          <md-button class="bg" style="color:white;" ng-disabled="projectForm.$invalid" ng-click="login(user, event)">
            Login
          </md-button>
        </form>
        </md-dialog-actions>
    </md-dialog>
</script>

</body>


</html>
