app.controller('notificationCtrl', function ($scope, $http, $window) {
	$scope.x = 0;
	$scope.notes = [];

	function getNotifications() {
		$http.get('/get/notifications').then(function (result) {
			$scope.notifications = result.data.notifications;
			$scope.haveNotifications = false;
			
			$scope.x = 0;

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
	}

	getNotifications();


	setInterval(getNotifications, 60000)
	
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

	$scope.limit = 5;
	$scope.showMore = function (event) {
		event.stopPropagation();
		$scope.limit += 5;
		if($scope.limit >= $scope.x) {
			$scope.noMore = true;
		}
	}
})
