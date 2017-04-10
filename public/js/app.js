var app = angular.module('BlankApp', [ 'angular.filter', 'ngMaterial',
		'ngMessages', 'ngFacebook', 'ui-notification', 'angular-circles' ])
app.config(function(NotificationProvider) {
	NotificationProvider.setOptions({
		delay : 10000,
		startTop : 20,
		startRight : 10,
		verticalSpacing : 20,
		horizontalSpacing : 20,
		positionX : 'left',
		positionY : 'bottom'
	});
});

app.directive('clickEnter', function() {
	return function(scope, element, attrs) {
		element.bind("keydown keypress", function(event) {
			if (event.which === 13) {
				scope.$apply(function() {
					scope.$eval(attrs.myEnter);
				});

				event.preventDefault();
			}
		});
	};
});

app.config([ 'ngCirclesSettingsProvider', function(ngCirclesSettingsProvider) {
	ngCirclesSettingsProvider.set({
		colors : [ '#f1c40f', '#c0392b' ]
	});
} ]);

app.config(
		[
				'$facebookProvider',
				function($facebookProvider) {
					$facebookProvider.setAppId('574057599463983')
							.setPermissions([ 'email', 'user_friends' ]);
				} ]).run(
		[ '$rootScope', '$window', function($rootScope, $window) {
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id))
					return;
				js = d.createElement(s);
				js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			$rootScope.$on('fb.load', function() {
				$window.dispatchEvent(new Event('fb.load'));
			});
		} ]);

app.controller('DemoBasicCtrl', function DemoCtrl($mdDialog, $scope, $facebook,
		$http, $window) {
	$scope.$on('fb.auth.authResponseChange', function() {
		$scope.status = $facebook.isConnected();
		if ($scope.status) {
			$facebook.api('/me').then(function(user) {
				$scope.user = user;
			});
		}
	});

	$scope.loginToggle = function() {
		$scope.loading = true;
		$facebook.login().then(function() {
			if (!$scope.status)
				return;
			$facebook.cachedApi('/me/friends').then(function(friends) {
				$scope.friends = friends.data;
				for (i = 0; i < friends.data.length; i++) {
					$http.post('/friend', {
						id : friends.data[i].id,
					})
				}
				setTimeout(function() {
					$window.location.reload();
				}, 3000)
			});
		});
	};

	$scope.rate = function(id) {
		$http.post('/rate/social', {
			rate : 5, // $scope.rate.n
			review : 'Review', // $scope.rate.review
			id : id,
		}).then(function() {
		})
	}

	this.settings = {
		printLayout : true,
		showRuler : true,
		showSpellingSuggestions : true,
		presentationMode : 'edit'
	};

	this.sampleAction = function(name, ev) {
		$mdDialog.show($mdDialog.alert().title(name).textContent(
				'You triggered the "' + name + '" action').ok('Great')
				.targetEvent(ev));
	};
	$scope.demo = {
		showTooltip : false,
		tipDirection : ''
	};

	$scope.demo.delayTooltip = undefined;
	$scope.$watch('demo.delayTooltip', function(val) {
		$scope.demo.delayTooltip = parseInt(val, 10) || 0;
	});

	$scope.$watch('demo.tipDirection', function(val) {
		if (val && val.length) {
			$scope.demo.showTooltip = true;
		}
	});

	// prompt
	$scope.signupPrompt = function(ev) {
		$mdDialog.show({
			templateUrl : 'signup.tmpl.html',
			parent : angular.element(document.body),
			targetEvent : ev,
			clickOutsideToClose : true,
			fullscreen : $scope.customFullscreen
		// Only for -xs, -sm breakpoints.
		}).then(function(answer) {
			$scope.status = 'You said the information was "' + answer + '".';
		}, function() {
			$scope.status = 'You cancelled the dialog.';
		});
	};
	// end prompt

});

app
		.controller(
				'userCtrl',
				function($scope, $http, $mdDialog, $window) {
					// prompt
					$scope.loginPrompt = function(ev) {
						$mdDialog.show({
							templateUrl : 'login.tmpl.html',
							parent : angular.element(document.body),
							targetEvent : ev,
							clickOutsideToClose : true,
							fullscreen : $scope.customFullscreen
						// Only for -xs, -sm breakpoints.
						});
					};
					// end prompt
					// prompt
					$scope.loginPrompt = function(ev) {
						$mdDialog.show({
							controllerAs : 'forgetPassPrompt',
							templateUrl : 'login.tmpl.html',
							parent : angular.element(document.body),
							targetEvent : ev,
							clickOutsideToClose : true,
							fullscreen : $scope.customFullscreen, // Only for
							// -xs, -sm
							// breakpoints.
							controller : function($mdDialog) {
								this.click = function click() {
									$mdDialog.show({
										controllerAs : 'forgetPassPrompt',
										controller : function($mdDialog) {
											this.click = function() {
												$mdDialog.hide();
											}
										},
										preserveScope : true,
										autoWrap : true,
										skipHide : true,
										clickOutsideToClose : true,
										templateUrl : 'forgetpass.tmpl.html',
									})
								}
							},
						});
					};
					// end prompt
					// sign up
					$scope.signup = function(user) {

						$scope.loading = [];
						$scope.loading.register = true;

						$http
								.post('/api/user/create', {
									email : user.email,
									fname : user.fname,
									lname : user.lname,
									dof : user.dof,
									gender : user.gender,
									password : user.password,
								})
								.then(
										function(data) {
											$scope.loading.register = false;
											if (data.data.state == true) {
												$scope
														.showAlert(
																'Done!',
																'Your account has been made successfully, check your e-mail for the verification code.',
																'Okay!', true);
											}
											if (data.data.state == 'existsAndConfirmed') {
												$scope
														.showAlert(
																'Done!',
																'Email already exists, you can login with your email.',
																'Okay!', true);
											}
											if (data.data.state == 'existsAndEmailed') {
												$scope
														.showAlert(
																'Done!',
																'Email already exists, check your email for the verification code.',
																'Okay!', true);
											}
											if (data.data.state == 'existsWithEmailProblem') {
												$scope
														.showAlert(
																'Done!',
																'Email already exists, and there is a problem sending verification email, please try again later.',
																'Okay!', false);
											}
										})
					}
					// end sign up

					$scope.myFunct = function(user, keyEvent) {
						if (keyEvent.which === 13)
							$scope.login(user, keyEvent);
					}

					// login
					$scope.login = function(user, e) {
						$scope.loading = [];
						$scope.loading.login = true;
						$http
								.post('/api/user/login', {
									email : user.email,
									password : user.password,
								})
								.then(
										function(data) {
											$scope.loading.login = false;
											if (data.data.state == true) {
												document.getElementById(
														"projectForm").submit();
											}
											if (data.data.state == false) {
												$scope
														.showAlert(
																'Error',
																'Email and Password Don\'t match!',
																'Try again!',
																true);
											}
											if (data.data.state == 'notConfirmed') {
												$scope
														.showAlert(
																'Error',
																'Your account is not verified yet, Please check your mail to verify your account.',
																'Okay!', false);
											}
										})
					}
					// end login

					// Forget Password
					$scope.forgetpass = function(user, e) {

						$scope.loading = [];
						$scope.loading.forgetpass = true;
						$http
								.post('/api/user/forgetpass', {
									email : user.email,
								})
								.then(
										function(data) {
											$scope.loading.forgetpass = false;
											if (data.data.state == true) {
												$scope
														.showAlert(
																'Success',
																'An e-mail was sent to you account',
																'Okay!', true);
											}
											if (data.data.state == false) {
												$scope.showAlert('Error',
														'Email not found!',
														'Try again!', true);
											}
											if (data.data.state == 'mailserver') {
												$scope
														.showAlert(
																'Error',
																'Problem with mail server, please contact the administrator!',
																'Try again!',
																true);
											}
										})
					}
					// Forget Password

					$scope.showAlert = function(title, text, button,
							openLoginDialog) {
						$mdDialog.show(
								$mdDialog.alert().clickOutsideToClose(true)
										.title(title).textContent(text).ok(
												button)).then(function() {
							if (openLoginDialog) {
								$scope.loginPrompt();
							}
						});
					};

				});

app.controller('dashController', function($scope, $mdDialog, $http, $timeout,
		$q, $log) {

	$scope.getFriends = function() {
		$http.post('/getFriends', {
			id : id
		}).then(function(result) {
			$scope.friends = result.data.friends;
		});
	}
	$scope.getFriends();

	$scope.search = '';

	$scope.cropImagePrompt = function(ev) {
		$mdDialog.show({
			templateUrl : 'crop.image.pp',
			parent : angular.element(document.body),
			targetEvent : ev,
			clickOutsideToClose : false,
			fullscreen : $scope.customFullscreen
			// Only for -xs, -sm breakpoints.
		});
	};

	$scope.uploadImg = function(userImg) {

		var fd = new FormData();
		// Take the first selected file
		fd.append("imgPP", userImg[0]);

		$http.post('/profile/uploadPP', fd, {
			withCredentials : true,
			headers : {
				'Content-Type' : undefined
			},
			transformRequest : angular.identity
		}).success(function(data) {

			$scope.cropImagePrompt();
			console.log(data.imageSrc);
			
			var updated = setInterval(function() {
				if (typeof ($('#cropbox')) != "undefined") {
					document.getElementById('cropbox').src = data.imageSrc;
					function updateCoords(c) {
						$('#x').val(c.x);
						$('#y').val(c.y);
						$('#w').val(c.w);
						$('#h').val(c.h);
					}
					
						$('#cropbox').Jcrop({
							onSelect : updateCoords
						});

					
					clearInterval(updated);
				}

			}, 50);

			function checkCoords() {
				if (parseInt($('#w').val()))
					return true;
				alert('Please select a crop region then press submit.');
				return false;
			}
			;

		}).error(function(data, status) {
			console.log('bad');
		});

	}

	$scope.$watch('search', function() {
		$scope.r = $scope.search;
		$http.post('/get/users', {
			'search' : $scope.search,
		}).then(function(result) {
			setTimeout(function() {
				if (result.data.users.length > 0) {
					$scope.results = result.data.users;
					$scope.$apply();
				} else {
					$scope.results = false;
				}
			}, 0);
		})
	})
});

app.controller('loadingCtrl', function($scope) {

	$scope.loading = true;

	document.onreadystatechange = function() {
		if (document.readyState == "complete") {
			$scope.loading = false;
		}
	}
});
