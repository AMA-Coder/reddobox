app.controller('boxCtrl', function ($scope, $http, $window) {
	$scope.denyFriendRequest = function (id) {
		$http.post('/new/deleteRequest/' + id).then(function (res) {
			if(res.data.check == true) {
				$scope.hasSentRequest = false;
				$scope.isFriend = false;
				$http.post('/readNotification', {
					from_id: id,
				}).then(function () {
					$window.location.reload();
				});
			}
		});
	}

	$scope.acceptFriendRequest = function (id, from_id, fname, lname) {
		$scope.fname = fname;
		$scope.lname = lname;
		$http.post('/new/acceptFriendRequest/' + id).then(function (res) {
			if(res.data.check == true) {
				$scope.isFriend = true;
				$scope.hasSentRequest = false;
				$scope.hasFriendRequestFrom = false;
				$http.post('/notify', {
					user_id: id,
					from_id: from_id,
					text: $scope.fname.toString() + ' ' + $scope.lname.toString() + ' has accepted your friend request.',
					url: '/profile/'+from_id
				}).then(function() {
					$http.post('/readNotification', {
						from_id: id,
					}).then(function () {
						$window.location.reload();
					})
				})
			}
		});
	}
})