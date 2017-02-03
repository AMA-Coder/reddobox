app.controller('professionalCtrl', function ($scope, $mdDialog, $http, $rootScope, $window) {
  $scope.showPrompt = function($event, newProjectRoute) {
  	$rootScope.newProjectRoute = newProjectRoute;
       var parentEl = angular.element(document.body);
       $mdDialog.show({
         parent: parentEl,
         targetEvent: $event,
         template:`
           <md-dialog aria-label="List dialog" style="width: 40%; padding: 10px; color: black !important">
             <md-dialog-content>
             	<br>
		          <md-input-container class="md-block" flex-gt-sm>
		            <label>Select the type</label>
		            <md-select ng-model="project.type">
		              <md-option ng-repeat="type in types" value="{{type}}">
		                {{type}}
		              </md-option>
		            </md-select>
		          </md-input-container>
		          <br>
			      <md-input-container class="md-block" flex-gt-sm>
			        <label>Enter the Title</label>
			        <input ng-model="project.title">
			      </md-input-container>
			      <br>
			      <md-input-container class="md-block" flex-gt-sm>
			        <label>Enter the Description</label>
			        <textarea md-maxlength="150" rows="5" md-select-on-focus ng-model="project.desc">
			        </textarea>
			      </md-input-container>
             </md-dialog-content>
             <md-dialog-actions>
               <md-button ng-click="closeDialog()" class="md-primary">
                 Submit
               </md-button>
             </md-dialog-actions>
           </md-dialog>`,
         locals: {
           items: $scope.items
         },
         controller: aCtrl
      });
  };

    function aCtrl($scope, $mdDialog) {
    	$scope.route = $rootScope.newProjectRoute;
      $scope.project = {};
      $scope.types = ['Project', 'Event'];
      $scope.closeDialog = function() {
      	console.log($scope.route)
      	if($scope.project.title && $scope.project.desc && $scope.project.type) {
	        $mdDialog.hide();
	        console.log($scope.project)
	        $http.post($scope.route, {
	        	details: $scope.project
	        }).then(function () {
            $window.location.reload()
          })
      	}
      }
    }

});

app.controller('projectCtrl', function ($scope, $mdDialog, $http, $rootScope) {
  $scope.showPrompt = function($event, friends, project) {
  	$rootScope.friends = JSON.parse(friends);
  	$rootScope.projectID = JSON.parse(project);
  	console.log($rootScope.projectID)
       var parentEl = angular.element(document.body);
       $mdDialog.show({
         parent: parentEl,
         targetEvent: $event,
         template:`
           <md-dialog aria-label="List dialog">
             <md-dialog-content>
             	<div ng-controller="rateCtrl" ng-repeat="friend in friends">
             		{{friend.fname + ' ' + friend.lname}}
             		<input type="checkbox" value="friend.id" ng-checked="checkIfInvited(friend.id)" ng-click="inviteToggle(friend.id)">
             		<br>
             	</div>
             </md-dialog-content>
             <md-dialog-actions>
               <md-button ng-click="closeDialog()" class="md-primary">
                 Done
               </md-button>
             </md-dialog-actions>
           </md-dialog>`,
         controller: aCtrl
      });
  };

    function aCtrl($scope, $mdDialog, $rootScope) {
      var s = 0;
    	$scope.checkIfInvited = function (user_id) {
        if(s==0) {
          s=1;
          var checks = $http.get('/invite/check/' + user_id + '/' + $rootScope.projectID).then(function (result) {
            console.log(result.data);
            if(result.data.check == true) {
              var check = true;
              return check;
            }else{
              var check = false;
              return check;
            }
          })
        }else{
          if(checks == true) {
            console.log('a')
            return true;
          }else{
            console.log('b')
            return false;
          }
        }
    	};
    	$scope.friends = $rootScope.friends;
    	$scope.inviteToggle = function (id) {
    		$http.post('/invite/toggle/' + id, {
    			projectID: $rootScope.projectID,
    		})
    	}
      $scope.closeDialog = function() {
        $mdDialog.hide();
   	  }
    }

    $scope.rateModel = [];

    $scope.Rate = function (user_id, project_id, rate, review) {
      $http.post('/rate/professional/' + user_id + '/rate/' + project_id, {
        rate: rate,
        review: review,
      }).then(function (result) {
        if (result.data.check == true) {
          swal('Done');
        }else{
          swal('Error');
        }
      });
    }
});