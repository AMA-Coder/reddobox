var app = angular.module('BlankApp', ['angular.filter', 'ngMaterial', 'ngMessages', 'ngFacebook', 'ui-notification', 'angular-circles'])
app.config(function(NotificationProvider) {
        NotificationProvider.setOptions({
            delay: 10000,
            startTop: 20,
            startRight: 10,
            verticalSpacing: 20,
            horizontalSpacing: 20,
            positionX: 'left',
            positionY: 'bottom'
        });
    });

app.directive('clickEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
                scope.$apply(function (){
                    scope.$eval(attrs.myEnter);
                });

                event.preventDefault();
            }
        });
    };
});

app.config(['ngCirclesSettingsProvider', function (ngCirclesSettingsProvider) {
        ngCirclesSettingsProvider.set({
            colors: ['#f1c40f', '#c0392b']
        });
    }]);

  app.config(['$facebookProvider', function($facebookProvider) {
    $facebookProvider.setAppId('574057599463983').setPermissions(['email','user_friends']);
  }])
  .run(['$rootScope', '$window', function($rootScope, $window) {
    (function(d, s, id) {
      var js, fjs = d.getElementsByTagName(s)[0];
      if (d.getElementById(id)) return;
      js = d.createElement(s); js.id = id;
      js.src = "//connect.facebook.net/en_US/sdk.js";
      fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    $rootScope.$on('fb.load', function() {
      $window.dispatchEvent(new Event('fb.load'));
    });
  }]);

  app.controller('DemoBasicCtrl', function DemoCtrl($mdDialog, $scope, $facebook, $http, $window) {
    $scope.$on('fb.auth.authResponseChange', function() {
      $scope.status = $facebook.isConnected();
      if($scope.status) {
        $facebook.api('/me').then(function(user) {
          $scope.user = user;
          console.log(user)
        });
      }
    });

    $scope.loginToggle = function() {
        $scope.loading = true;
      $facebook.login().then(function () {
      if(!$scope.status) return;
        $facebook.cachedApi('/me/friends').then(function(friends) {
          $scope.friends = friends.data;
          console.log(friends.data[0].id)
          for (i=0;i<friends.data.length;i++) {
            $http.post('/friend', {
                id: friends.data[i].id,
            })
          }
          setTimeout(function () {
            $window.location.reload();
          }, 3000)
        });
      });
    };

    $scope.rate = function (id) {
        $http.post('/rate/social', {
            rate: 5, //$scope.rate.n
            review: 'Review', //$scope.rate.review
            id: id,
        }).then(function () {
            console.log('Done!');
        })
    }

    this.settings = {
      printLayout: true,
      showRuler: true,
      showSpellingSuggestions: true,
      presentationMode: 'edit'
    };

    this.sampleAction = function(name, ev) {
      $mdDialog.show($mdDialog.alert()
        .title(name)
        .textContent('You triggered the "' + name + '" action')
        .ok('Great')
        .targetEvent(ev)
      );
    };
  $scope.demo = {
    showTooltip : false,
    tipDirection : ''
  };

  $scope.demo.delayTooltip = undefined;
  $scope.$watch('demo.delayTooltip',function(val) {
    $scope.demo.delayTooltip = parseInt(val, 10) || 0;
  });

  $scope.$watch('demo.tipDirection',function(val) {
    if (val && val.length ) {
      $scope.demo.showTooltip = true;
    }
  });

  //prompt
  $scope.signupPrompt = function(ev) {
    $mdDialog.show({
      templateUrl: 'signup.tmpl.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose:true,
      fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
    })
    .then(function(answer) {
      $scope.status = 'You said the information was "' + answer + '".';
    }, function() {
      $scope.status = 'You cancelled the dialog.';
    });
  };
  //end prompt

  //prompt
  $scope.loginPrompt = function(ev) {
    $mdDialog.show({
      templateUrl: 'login.tmpl.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose:true,
      fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
    });
  };
  //end prompt
  });

  app.controller('userCtrl', function ($scope, $http, $mdDialog, $window) {
  //prompt
  $scope.loginPrompt = function(ev) {
    $mdDialog.show({
      templateUrl: 'login.tmpl.html',
      parent: angular.element(document.body),
      targetEvent: ev,
      clickOutsideToClose:true,
      fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
    });
  };
  //end prompt
  // sign up
  	$scope.signup = function (user) {
  		$http.post('/api/user/create', {
  			email: user.email,
  			fname: user.fname,
  			lname: user.lname,
  			dof: user.dof, 
  			gender: user.gender,
  			password: user.password,
  		}).then(function (data) {
  			console.log(data.data.state)
  			if(data.data.state) {
  				$scope.showAlert('Done!', 'Check your email to see the confirmation code.', 'Okay!', false);
  			}
  		})
  	}
  // end sign up

$scope.myFunct = function(user, keyEvent) {
  if (keyEvent.which === 13)
    $scope.login(user, keyEvent);
}

  //login
  	$scope.login = function (user, e) {
  		$http.post('/api/user/login', {
  			email: user.email,
  			password: user.password,
  		}).then(function (data) {
        if(data.data.confirmed) {
          if(data.data.state) {
            document.getElementById("projectForm").submit();
          }else{
            $scope.showAlert('Error', 'Email and Password Don\'t match!', 'Try again!', true);
          }
        }else{
            $scope.showAlert('Error', 'Your account is not verified yet, Please check your mail to verify your account.', 'Okay!', false);
        }
  		})
  	}
  //end login

    $scope.showAlert = function(title, text, button, openLoginDialog) {
      $mdDialog.show(
        $mdDialog.alert()
          .clickOutsideToClose(true)
          .title(title)
          .textContent(text)
          .ok(button)
      ).then(function () {
        if(openLoginDialog) {
          $scope.loginPrompt();
        }
      });
    };

  });

app.controller('dashController', function ($scope, $http, $timeout, $q, $log) {
    $scope.getFriends = function () {
      $http.get('/getFriends').then(function (result) {
        $scope.friends = result.data.friends;
        console.log($scope.friends)
      });
    }
    $scope.getFriends();

    $scope.search = '';

    $scope.$watch('search', function () {
      $scope.r = $scope.search;
      $http.post('get/users', {
        'search': $scope.search,
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


