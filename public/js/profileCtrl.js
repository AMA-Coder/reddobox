app.controller('profileCtrl', function ($scope, $http, $window) {

	$http.post('/new/checkIfFriend/' + id).then(function (res) {
		//console.log(res.data.check);
		if(res.data.check == true) {
			$scope.isFriend = true;
		}else{
			$scope.isFriend = false;
		}
	});

	$http.post('/new/hasSentFriendRequestTo/' + id).then(function (res) {
		console.log(res.data.check);
		if(res.data.check == true) {
			$scope.hasSentRequest = true;
		}else{
			$scope.hasSentRequest = false;
		}
	});

	$http.post('/new/hasFriendRequestFrom/' + id).then(function (res) {
		//console.log(res.data.check);
		if(res.data.check == true) {
			$scope.hasFriendRequestFrom = true;
		}else{
			$scope.hasFriendRequestFrom = false;
		}
	});

	$scope.sendRequest = function (id, from_id) {
		$http.post('/new/friendRequest/' + id).then(function (res) {
			//console.log(res.data.check);
			if(res.data.check == true) {
				$scope.hasSentRequest = true;
				$http.post('/notify', {
					user_id: id,
					from_id: from_id,
					text: 'You have a new friend request!',
					url: '/dashboard'
				})
			}
		});
	}
	$scope.removeRequest = function (id) {
		$http.post('/new/deleteRequest/' + id).then(function (res) {
			//console.log(res.data.check);
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
			//console.log(res.data.check);
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

					})
				})
			}
		});
	}
	$scope.block = function (id) {
		$http.post('/new/block/' + id).then(function (res) {
			//console.log(res.data.check);
			$http.post('/readNotification', {
				from_id: id,
			}).then(function () {
				$window.location.reload();
			});
		});
	}
	$scope.unblock = function (id) {
		$http.post('/new/unblock/' + id).then(function (res) {
			//console.log(res.data.check);
			$window.location.reload();
		});
	}

});