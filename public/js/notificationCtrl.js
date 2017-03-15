app.controller('notificationCtrl', function ($scope, $http, $window) {

	function getNotifications() {
		$http.get('/get/notifications').then(function (result) {
			$scope.notifications = result.data.notifications;
			$scope.haveNotifications = false;
			
			$scope.notes = [];
			$scope.socialNotes = [];
			$scope.personalNotes = [];

			for (var i = $scope.notifications.length - 1; i >= 0; i--) {
				// if($scope.notifications[i].state == 1) {
				// 	$scope.x += 1;
				// }
				// if($scope.notifications[i].state == 1) {
				// 	$scope.haveNotifications = true;
				// }
				// if($scope.notifications[i].state == 1) {
				// 	$scope.notes.push($scope.notifications[i]);
				// }
				if($scope.notifications[i].text == 'Someone rated you socially!' && $scope.notifications[i].state == 1) {
					$scope.socialNotes.push($scope.notifications[i]);
				}
				else if($scope.notifications[i].text == 'Someone rated you personally!' && $scope.notifications[i].state == 1) {
					$scope.personalNotes.push($scope.notifications[i]);
				}
				else if($scope.notifications[i].state == 1){
					$scope.notes.push($scope.notifications[i]);
				}
			}
			console.log($scope.socialNotes, $scope.personalNotes, $scope.notes)
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
