app.controller('pwResetCtrl', function ($scope, $http) {

    $scope.resetPassword = function () {
        $http.post('/password_reset', {
          new_password: $scope.new_password
        }).then(function (res) {
            if(res.data.state == true) {
                swal('Done!');
            }
            if(res.data.state == false) {
                swal('Ops, something went wrong..')
            }
            if(res.data.state == 'length_error') {
                swal('Password must be 6 characters or more..')
            }
        })
    }

});