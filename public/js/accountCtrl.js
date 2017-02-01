app.controller('accountCtrl', function ($scope) {
	$scope.user = user;
	console.log($scope.user)
	$scope.edit = function () {
		
	}
	
  $scope.myDate = new Date();

  $scope.minDate = new Date(
      $scope.myDate.getFullYear() - 80,
      $scope.myDate.getMonth(),
      $scope.myDate.getDate());

  $scope.maxDate = new Date(
      $scope.myDate.getFullYear() - 15,
      $scope.myDate.getMonth(),
      $scope.myDate.getDate());
});