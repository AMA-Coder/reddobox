app.controller('accountCtrl', function ($scope, $http) {
	$scope.user = user;
  if(!$scope.user.dof) {
    $scope.user.dof = 'dd-mm-yyyy'
  }
	console.log($scope.user)
	$scope.edit = function (id) {
    if($scope.user.dof == 'dd-mm-yy') {
      $scope.user.dof = null;
    }
    $http.post('/api/user/edit', {
      user: $scope.user,
      id: id
    }).then(function (res) {
      if(res.data.check) {
        swal('Done');
      }else{
        swal('Something went wrong, try again')
        $scope.user.dof = 'dd-mm-yyyy'
      }
    })
	}
});