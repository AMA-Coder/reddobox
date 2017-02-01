app.controller('noteCtrl', function ($scope, $http) {
	$http.get('get/notifications').then(function (result) {
		$scope.notifications = result.data.notifications;
	})
})