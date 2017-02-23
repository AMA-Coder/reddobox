  app.controller('socialRateCtrl', function ($scope, $mdDialog, $http, $window) {
    $scope.review = '';

    $scope.changeBool = function (trait_id) {
            if($scope.ss[trait_id] == 0) {
                $scope.bool[trait_id] = false;
            }
            if($scope.ss[trait_id] != 0) {
                $scope.bool[trait_id] = true;
            }            
    }

    $scope.zeroRate = function (trait_id) {
        $scope.ss[trait_id] = 0;
    }

      $http.get('/rate/get_traits/social').then(function(res) {
        $scope.social_traits = res.data.traits;
      })


      $http.post('/rate/get', {
        from_id: from_id,
        user_id: user_id,
        category: 'social',
      }).then(function(result) {
        if(result.data.rate) {
          $scope.social = result.data.rate;
          console.log(result.data.rate)
          $scope.ss = [];
          $scope.bool = [];
          angular.forEach($scope.social, function(v, k) {
            $scope.ss[v.rate_trait_id] = v.rate;
            if(v.rate == 0) {
                $scope.bool[v.rate_trait_id] = false;
            }else{
                $scope.bool[v.rate_trait_id] = true;
            }
            $scope.review = v.review;
          })
        }
      })

          $('#social_submit').on('click', function() {
            console.log($scope.ss)
              var $this = $(this);
            $this.button('loading');
            $http.post('/rate/social', {
                review: $scope.review, 
                id: user_id,
                rates: $scope.ss
            }).then(function (data) {
              if(data.data.check) {
                    $this.button('reset');
                    swal({
                      title: 'Done!',
                    }, function () {
                      window.location.href = '/';
                    });
                    $scope.notify(user_id, 'Someone rated you socially!');
                }else{
                    $this.button('reset');
                    swal('Failed, Try again later!');
                }
            })
          });

      $scope.notify = function (url_id, text) {
        $http.post('/notify', {
          from_id: from_id,
          user_id: user_id,
          text: text,
          url: '/rate/details/',
        })
      }

});

  app.controller('personalRateCtrl', function ($scope, $mdDialog, $http, $window) {
    $scope.review = '';

    $scope.changeBool = function (trait_id) {
            if($scope.ss[trait_id] == 0) {
                $scope.bool[trait_id] = false;
            }
            if($scope.ss[trait_id] != 0) {
                $scope.bool[trait_id] = true;
            }            
    }

    $scope.zeroRate = function (trait_id) {
        $scope.ss[trait_id] = 0;
    }

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
          $scope.bool = [];
          angular.forEach($scope.personal, function(v, k) {
            $scope.ss[v.rate_trait_id] = v.rate;
            if(v.rate == 0) {
                $scope.bool[v.rate_trait_id] = false;
            }else{
                $scope.bool[v.rate_trait_id] = true;
            }
            $scope.review = v.review;
          })
        }
      })

          $('#personal_submit').on('click', function() {
              var $this = $(this);
            $this.button('loading');
            $http.post('/rate/personal', {
                review: $scope.review, 
                id: user_id,
                rates: $scope.ss
            }).then(function (data) {
              if(data.data.check) {
                $this.button('reset');
                    swal({
                      title: 'Done!',
                    }, function () {
                      window.location.href = '/';
                    });
                    $scope.notify(user_id, 'Someone rated you personally!');
                }else{
                    swal('Failed, Try again later!');
                }
            })
          });

      $scope.notify = function (url_id, text) {
        $http.post('/notify', {
          from_id: from_id,
          user_id: user_id,
          text: text,
          url: '/rate/details/',
        })
      }
})