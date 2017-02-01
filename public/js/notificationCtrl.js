app.controller('notificationCtrl', function ($scope, $http, $window) {
	$scope.x = 0;
	$scope.notes = [];
	$http.get('/get/notifications').then(function (result) {
		$scope.notifications = result.data.notifications;
		console.log(result)
		$scope.haveNotifications = false;
		
		for (var i = $scope.notifications.length - 1; i >= 0; i--) {
			if($scope.notifications[i].state == 1) {
				$scope.x += 1;
			}
			if($scope.notifications[i].state == 1) {
				$scope.haveNotifications = true;
			}
			if($scope.notifications[i].state == 1) {
				$scope.notes.push($scope.notifications[i]);
			}

		}
	})
	
	$scope.getCount = function (i) {
	    var iCount = iCount || 0;
	    for (var j = 0; j < $scope.notifications.length; j++) {
	        if ($scope.notifications[j].text == i && $scope.notifications[j].state == 1) {
	            iCount++;
	        }
	    }
	    return iCount;
	}

	$scope.read = function (text, href) {
		$http.post('/readNotification', {
			text: text,
		}).then(function () {
			if(href) {
				$window.location.href = href;
			}
		})
	}
})
