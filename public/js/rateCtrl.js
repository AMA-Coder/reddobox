  app.controller('socialRateCtrl', function ($scope, $mdDialog, $http, $window) {
    $scope.rate = function(ev, id) {
      localStorage.setItem('rate_to_id', id);
      $mdDialog.show({
        templateUrl: '../../rate/choose.tmpl.html',
        parent: angular.element(document.body),
        targetEvent: ev,
        clickOutsideToClose:true,
        fullscreen: $scope.customFullscreen // Only for -xs, -sm breakpoints.
      })
    };

      $http.post('/rate/get', {
        from_id: from_id,
        user_id: user_id,
        category: 'social',
      }).then(function(result) {
        if(result.data.rate) {
          $scope.social = result.data.rate;
          console.log(result.data.rate)
          $scope.ss = [];
          angular.forEach($scope.social, function(v, k) {
            $scope.ss[v.rate_trait_id] = v.rate;
          })
        }
      })

      $http.get('/rate/get_traits/social').then(function(res) {
        $scope.social_traits = res.data.traits;
      })


      $scope.submit_social = function (cat) {
        angular.forEach($scope.ss, function (v, k) {
          $http.post('/rate/social', {
              trait_id: k,
              rate: v,
              review: 'Review', 
              id: user_id,
          }).then(function (data) {
            if(data.data.check == true) {
              swal('Done!');
            }else{
              swal('Failed, Try again later!');
            }
          })
        })
        $scope.notify(user_id, 'Someone rated you socially!');
      }

      $scope.notify = function (url_id, text) {
        $http.post('/notify', {
          from_id: from_id,
          user_id: user_id,
          text: text,
          url: '/profile/' + url_id,
        })
      }
});

  app.controller('personalRateCtrl', function ($scope, $mdDialog, $http, $window) {

      $http.get('/rate/get_traits/personal').then(function(res) {
        $scope.personal_traits = res.data.traits;
      })


      $http.post('/rate/get', {
        from_id: from_id,
        user_id: user_id,
        category: 'personal',
      }).then(function(result) {
        if(result.data.rate) {
          $scope.personal = result.data.rate;
          console.log(result.data.rate)
          $scope.ss = [];
          angular.forEach($scope.personal, function(v, k) {
            $scope.ss[v.rate_trait_id] = v.rate;
          })
          console.log($scope.ss)
        }
      })

      $scope.submit_personal = function (cat) {
        angular.forEach($scope.ss, function (v, k) {
          $http.post('/rate/personal', {
              trait_id: k,
              rate: v,
              review: 'Review', 
              id: user_id,
          }).then(function (data) {
            if(data.data.check == true) {
              swal('Done!');
            }else{
              swal('Failed, Try again later!');
            }
          })
        })
        $scope.notify(user_id, 'Someone rated you personally!');
      }

      $scope.notify = function (url_id, text) {
        $http.post('/notify', {
          from_id: from_id,
          user_id: user_id,
          text: text,
          url: '/profile/' + url_id,
        })
      }
})