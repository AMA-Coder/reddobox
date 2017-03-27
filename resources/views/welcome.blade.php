<html lang="en">
<head>

<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- Angular Material style sheet -->
<link rel="stylesheet"
	href="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.css">
<link rel="stylesheet" type="text/css" href="css/style.css">
<LINK REL="SHORTCUT ICON" HREF="images/icon.ico">
<title>Reddo-box</title>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-33979560-3', 'auto');
  ga('send', 'pageview');

</script>
</head>
<!-- Angular Material requires Angular.js Libraries -->
<script
	src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-animate.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-aria.min.js"></script>
<script
	src="http://ajax.googleapis.com/ajax/libs/angularjs/1.5.5/angular-messages.min.js"></script>
<script src=" {{url('/js/ngFacebook.js')}} "></script>
<!-- Angular Material Library -->
<script
	src="http://ajax.googleapis.com/ajax/libs/angular_material/1.1.0/angular-material.min.js"></script>
<script src="{{url('/js/app.js')}}"></script>
<script src="{{url('/js/angular-filter.min.js')}}"></script>
<script src="//rawgit.com/lugolabs/circles/master/circles.js"></script>
<script
	src="//rawgit.com/ActivKonnect/angular-circles/master/angular-circles.js"></script>

<script type="text/javascript"
	src="{{url('extensions/notifications/angular-ui-notification.min.js')}}"></script>
<link rel="stylesheet"
	href="{{url('extensions/notifications/angular-ui-notification.min.css')}}">
<script
	src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<!-- sweet alert -->
<link rel="stylesheet" type="text/css"
	href=" {{url('extensions/swal/sweetalert.css')}} ">
<script type="text/javascript"
	src="{{url('extensions/swal/sweetalert.min.js')}}"></script>
<link rel="stylesheet" type="text/css"
	href="{{url('css/bootstrap.min.css')}}">
<script src="{{url('js/bootstrap.min.js')}}"></script>
<body ng-app="BlankApp" layout-fill layout="column" ng-cloak>
	<!--Your HTML content here-->
	@if (isset($_GET['confirmed']) == 1)
	<script type="text/javascript">
    swal({title: 'Confirmed!'}, function () {
      window.location = '/';
    });
  </script>
	@endif
	<div class="" ng-controller="DemoBasicCtrl as ctrl">
		<!-- container of everything-->

		<div id="cover">
			<!-- container of the cover area-->
			<div class="row" style="margin: 0px;">
				<div class="col-lg-4 col-md-6 col-sm-8 col-xs-12">
					<div id="logo">
						<img src="images/logo.png">
					</div>
				</div>
			</div>
			<div class="dialog-demo-content"
				style="margin: 0px; margin-top: -100px; width: 100%;" layout="row"
				layout-wrap layout-margin layout-align="margin-left">
				<div class="row"
					style="width: 100%; margin-left: 0px; margin-right: 0px;">
					<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12"
						style="text-align: center; font-size: 10vh; font-weight: bold; color: white;">
						Feedback<br>The World
					</div>
				</div>
				<div class="row" style="width: 100%; margin: 0px;" >
					<div class="col-md-7 col-md-offset-1 col-sm-12">
						<form name="projectForm" ng-controller="userCtrl">
							<md-dialog-content>
							<div class="md-dialog-content">
								<md-content layout-padding style="opacity:0.7"> <md-input-container
									class="md-block"> <label> Email address</label> <input
									minlength="6" maxlength="100" required md-no-asterisk
									name="email" ng-model="user.email" ng-pattern="/^.+@.+\..+$/">
								<div ng-messages="projectForm.email.$error">
									<div ng-message="required">This is required.</div>
									<div
										ng-message-exp="['required', 'minlength', 'maxlength', 'pattern']">
										Your email must be between 10 and 100 characters long and look
										like an e-mail address.</div>
								</div>
								<md-tooltip md-direction="bottom"> Email adress </md-tooltip> </md-input-container>

								<div layout="row">
									<md-input-container flex="50"> <label>First Name</label> <input
										md-maxlength="15" required name="fname" ng-model="user.fname">
									<div ng-messages="projectForm.fname.$error">
										<div ng-message="required">This is required.</div>
										<div ng-message="md-maxlength">The name must be less than 15
											characters long.</div>
									</div>
									<md-tooltip md-direction="bottom"> First Name </md-tooltip> </md-input-container>

									<md-input-container flex="50"> <label>Last Name</label> <input
										md-maxlength="15" required name="lname" ng-model="user.lname">
									<div ng-messages="projectForm.lname.$error">
										<div ng-message="required">This is required.</div>
										<div ng-message="md-maxlength">The name must be less than 15
											characters long.</div>
									</div>
									<md-tooltip md-direction="bottom"> Last Name </md-tooltip> </md-input-container>
								</div>

								<div layout="row">
									{{--
									<md-input-container flex="50"> <label>Date of birth</label> <input
										required name="dof" type="date" ng-model="user.dof">
									<div ng-messages="user.dof.$error">
										<div ng-message="required">This is required.</div>
									</div>
									<md-tooltip md-direction="bottom"> Date of birth </md-tooltip>
									</md-input-container>
									--}}
									<md-input-container flex="50"> <label>Gender</label> <md-select
										name="type" ng-model="user.gender" required> <md-option
										value="male">Male</md-option> <md-option value="female">Female</md-option>
									</md-select> <md-tooltip md-direction="bottom"> Gender </md-tooltip>
									</md-input-container>
								</div>
								<md-input-container class="md-block"> <label>Password</label> <input
									required type="password" name="password"
									ng-model="user.password" minlength="6" maxlength="30" />

								<div ng-messages="projectForm.password.$error"
									md-auto-hide="false" role="alert">
									<div ng-message-exp="['required', 'minlength', 'maxlength']">
										Your password must be between 6 and 30 characters long.</div>
								</div>
								<md-tooltip md-direction="bottom"> Password </md-tooltip> </md-input-container>

								<md-input-container class="md-block"> <label>Password
									Confirmation</label> <input required type="password"
									name="password_confirmation" ng-pattern="@{{user.password}}"
									ng-model="user.password_confirmation" />

								<div ng-messages="projectForm.password_confirmation.$error"
									md-auto-hide="false" role="alert">
									<div ng-message="pattern">The password doesn't match.</div>
								</div>
								</md-input-container> </md-content>
							</div>
							</md-dialog-content>

							<md-dialog-actions> 
							<div class="row" style="width: 100%;margin: 0px">
							
							<div class="col-sm-6" style="text-align: center;">
							<md-button type="submit"
								class="md-primary md-raised sign-up" style="color:white;min-width:160px;"
								ng-disabled="projectForm.$invalid || loading.register"
								ng-click="signup(user)"> <span ng-show="!loading.register">Register</span>
							<span ng-show="loading.register"><i class="fa fa-spinner"
								aria-hidden="true"></i> Loading</span> </md-button>
							</div>
							
							<div class="col-sm-6" style="text-align: center;">
								<md-button class="md-primary md-raised sign-up" style="min-width:160px;"
									ng-click="loginPrompt()"> Log in </md-button>
							</div>
							
							</div>
							<div style="color: white;font-size: 2em;font-weight: bold; text-align: center;">&#8212; OR &#8212;</div>
							<div class="row"  style="width: 100%;margin: 0px">
								<div class="col-lg-12" style="text-align: center;">
								<md-button class="md-primary md-raised sign-up"
									ng-click="" style="background-color:#3B5998 !important;min-width:160px;"> Facebook Log in </md-button>
							</div>
							</div>
							</md-dialog-actions>
						</form>

					</div>

				</div>
			</div>
		</div>
		<div id="footer">
			<div class="row" style="margin: 0px;">
				<div class="col-sm-7 footer-brand">
					<img src="/images/logo negative.png">
				</div>
				<div class="col-sm-3" style="text-align: center;">
					<a data-toggle="modal" href='#terms'>
						<h3 class="footer-link">Terms and conditions</h3>
					</a>
				</div>
				<div class="col-sm-2" style="text-align: center;">
					<a data-toggle="modal" href='#contact-us'>
						<h3 class="footer-link">Contact us</h3>
					</a>
				</div>
			</div>
		</div>

		<div class="modal fade" id="contact-us">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg color">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h4 class="modal-title">Contact us</h4>
					</div>
					<div class="modal-body">
						<h4>
							<span style="color: grey">Contact us at:</span> <br>
							<center>
								<span style="color: grey">Support@reddobox.com</span>
							</center>
						</h4>
					</div>
					<div class="modal-footer bg color">
						<br>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="terms">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header bg color">
						<button type="button" class="close" data-dismiss="modal"
							aria-hidden="true">&times;</button>
						<h4 class="modal-title">Terms and conditions</h4>
					</div>
					<div class="modal-body">
						<b>Welcome to Reddobox.com</b> <br> <br>

						<p>Thank you for using our service. Reddobox.com is a startup
							created by a group of engineering students who aim providing a
							new service to the world in the social networking filed. We
							started building the website October 2016 and we will continue to
							develop it to match our users’ needs. Reddobox.com is located in
							Egypt - 6th of October City - Giza. By using our Services, you
							are agreeing to the following terms. Please read it carefully.
							Reddobox.com terms of service</p>
						<br>
						<p>This statement includes our terms of service that governs the
							relationship between our users and Reddobox.com. By accessing,
							registering and/or continuing to use Reddox.com Services, you
							agree to this Statement with immediate effect.</p>
						<hr>
						<p>
							1- Reddobox.com will not share any of your passwords with any
							third parties (unless you authorize us to do so). <br> <br>2- The
							security of your account is our priority. We don’t recommend you
							share your passwords with others as it might affect account
							security. <br> <br>3- Your anonymous features will stay anonymous
							unless you share your information with people. <br> <br>4-
							Reddobox.com does not have any official mobile apps in the
							meantime. Any app with similar names is not related to
							Reddobox.com. <br> <br>5- Any account with false personal
							information might be blocked or suspended until further notice. <br>
							<br>6- Reddobox.com might use your information to help you see
							relative content. <br> <br>7- The upcoming updates in
							Reddobox.com might change those terms. 8- Last updated version of
							this document at 7th of March 2017.
						</p>
					</div>
					<div class="modal-footer bg color">
						<br>
					</div>
				</div>
			</div>
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
          <md-button class="bg" style="color:white;" ng-disabled="projectForm.$invalid || loading.login" ng-click="login(user, event)">
            <span ng-show="!loading.login">Login</span>
            <span ng-show="loading.login"><i class="fa fa-spinner" aria-hidden="true"></i> Loading</span>
          </md-button>
		<md-button class="bg" style="color:white;"  ng-click="forgetPassPrompt.click()">
            <span ng-show="!loading.forgetpass">Forget Password</span>
            <span ng-show="loading.forgetpass"><i class="fa fa-spinner" aria-hidden="true"></i> Loading</span>
          </md-button>
        </form>
        </md-dialog-actions>
    </md-dialog>
</script>

	<script type="text/ng-template" id="forgetpass.tmpl.html">
    <md-dialog aria-label="Forget Password" style="width:70%" ng-controller="userCtrl">
        <md-toolbar class="bg">
          <div class="md-toolbar-tools">
            <h2 class="bg">Forget Password</h2>
            <span flex></span>
          </div>
        </md-toolbar>

        <md-dialog-content>
          <div class="md-dialog-content">
              <md-content layout-padding>
                <form name="projectForm" method="post" id="projectForm">
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
              </md-content>
          </div>
        </md-dialog-content>

        <md-dialog-actions layout="row">
          <md-button class="bg" style="color:white;" ng-disabled="projectForm.$invalid || loading.forgetpass" ng-click="forgetpass(user, event)">
            <span ng-show="!loading.forgetpass">Send mail</span>
            <span ng-show="loading.forgetpass"><i class="fa fa-spinner" aria-hidden="true"></i> Loading</span>
          </md-button>
        </form>
        </md-dialog-actions>
    </md-dialog>


</body>


</html>
