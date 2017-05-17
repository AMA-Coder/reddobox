@extends('layouts.master')

@section('content')

<script type="text/javascript">
	app.controller('myPersonalCtrl', function($scope, $http) {
		$scope.loading = false;
	    $scope.log = function(v) {
	        console.log(v);
	    }
	    $scope.myTraits = {!!$myRates!!};

	    $scope.cc = function(v) {
	        var total = 0;
	        counter = 0;
	        for (var i = v.length - 1; i >= 0; i--) {
	            total = total + v[i].rate;
	            counter++;
	        }
	        return total / counter;
	    }

	    function sort(argument) {
	        angular.forEach(argument, function(v, k) {
	            argument[k].updated_at = argument[k][0].updated_at;
	        })
	        arr = Object.keys(argument).map(function(key) {
	            return argument[key];
	        });
	        arr.sort(function(a, b) {
	            a = new Date(a.updated_at);
	            b = new Date(b.updated_at);
	            return a > b ? -1 : a < b ? 1 : 0;
	        });
	        return arr;
	    }

	    $scope.sortChats = function (chats) {
	        chats.sort(function(a, b) {
	            a = new Date(a.updated_at);
	            b = new Date(b.updated_at);
	            return a > b ? -1 : a < b ? 1 : 0;
	        });
	    	return chats.reverse();
	    }

	    $scope.myRates = {!!$myRatesGrouped!!};
	    $scope.myRatesArray = sort($scope.myRates);

	    $scope.ratesByMe = {!!$ratesDoneByMe!!};
	    $scope.ratesByMeArray = sort($scope.ratesByMe);

	    $scope.refresh = function (event, DontRefresh) {
	    	if(!DontRefresh) {
		    	$scope.loading = true;
	    	}
	    	if(event) {
		    	event.preventDefault();
	    	}
		    $http.post('/rate/getPersonal').then(function(res) {
			    $scope.myRates = res.data.myRatesGrouped;
			    $scope.myRatesArray = sort($scope.myRates);
			    console.log(JSON.stringify($scope.ratesByMe) === JSON.stringify(res.data.ratesDoneByMe))
			    $scope.ratesByMe = res.data.ratesDoneByMe;
			    $scope.ratesByMeArray = sort($scope.ratesByMe);
		    }).then(function () {
		    	$scope.loading = false;
		    });
	    }

	    $scope.sendChat = function (from, to, anon, message, event) {
			if (event.which === 13) {
				$scope.loading = true;
		    	$http.post('/chat', {
		    		from: from,
		    		to: to,
		    		anon: anon,
		    		message: message
		    	}).then(function () {
			    	document.getElementById('chat').value = '';
			    	$scope.refresh();
		    	})
			}
	    }

	})
</script>
<div class="container"  style="min-height: 580px;" ng-controller="myPersonalCtrl">
<a href="#" class="float" ng-click="refresh($event)">
	<i class="fa fa-refresh my-float"></i>
</a>
<div class="middle" ng-show="loading">
<div class="windows8">
	<div class="wBall" id="wBall_1">
		<div class="wInnerBall"></div>
	</div>
	<div class="wBall" id="wBall_2">
		<div class="wInnerBall"></div>
	</div>
	<div class="wBall" id="wBall_3">
		<div class="wInnerBall"></div>
	</div>
	<div class="wBall" id="wBall_4">
		<div class="wInnerBall"></div>
	</div>
	<div class="wBall" id="wBall_5">
		<div class="wInnerBall"></div>
	</div>
</div>
</div>
	<div class="row" style="margin:0px;">
		<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
			<div class="thumbnail">
				<div class="image-upload">
					<center>
					<div class="image-container">
						<img src="{{secure_url('uploads/images/' . Auth::user()->avatar)}}" width="100%" class="image">
							<h4>Recieved <span class="badge">{{count(Auth::user()->rates())}}</span></h4>
							<h4>Reddo <span class="badge">{{count($ratesDoneByMe)}}</span></h4>
					</div>
					</center>
				</div>
			</div>
		</div>
		<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9">
			<div ng-repeat="(key, value) in myTraits | groupBy: 'trait_name'">
				<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
							<span class="overflowed">@{{key}}</span>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" ng-init="val = cc(value)">
							<jk-rating-stars max-rating="5" rating="val/5" read-only="1">
							</jk-rating-stars>
						</div>
				</div>
			</div>
		</div>
	</div>
	<hr>
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<center><h2>Recieved</h2></center>
	              <div class="panel panel-default arrow left" ng-repeat="rate in myRatesArray">
	                <div class="panel-body">
	                  <header class="text-left">
	                    <div class="comment-user"><i class="fa fa-user"></i>
	                    One of your friends gave you this feedback
	                    </div>
	                  </header>
	                  <div class="comment-post">
	                  <hr>
	        			<center>
	                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> @{{rate[0].updated_at | relativeDate}}</time>
	        			</center>
	        			<br>
	        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-repeat="trait in rate">	        				
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<img ng-src="/traits-icons/@{{trait.trait_name}}.png" width="25px" style="padding-right: 10px">
								<span class="overflowed">@{{trait.trait_name}}</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<jk-rating-stars max-rating="5" rating="trait.rate / 5" read-only="1">
								</jk-rating-stars>
							</div>
	        			</div>

	                  </div>
	                </div>
	              	<div class="panel-footer">
	                  <p>Your friend left a note:</p>
	                  <hr ng-show="rate[0].review">
	                  <div class="him">
	                  	<p>
	                  	@{{rate[0].review}}
	                  	<span ng-show="rate[0].review" style="font-style: italic; color: grey"> - @{{rate[0].updated_at | relativeDate}}</span>
							<span ng-show="!rate[0].review" style='font-style: italic; color: grey'>Your friend hasn't left a note!</span>
	                  	</p>
	                  </div>
	                  {{-- @{{myRatesArray}} --}}
	                  <div ng-init="rate[0].chats = sortChats(rate[0].chats)" ng-repeat="chat in rate[0].chats">
		                  <div ng-class="chat.from_id == {!!Auth::id()!!} ? 'me' : 'him'"><p> 
			                  @{{chat.message}}
			                  <span style='font-style: italic; color: grey'>
			                  	- @{{chat.updated_at | relativeDate}}
			                  </span>
		                  </p></div>
	                  </div>
	                  <input ng-keypress="sendChat({!!Auth::id()!!}, rate[0].from_id, rate[0].from_id, rate[0].myMessage, $event)" ng-model="rate[0].myMessage" type="text" class="form-control" placeholder="Reply.." id="chat">
	              	</div>
	              </div>

		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<center><h2>Reddo</h2></center>
	              <div class="panel panel-default arrow left" ng-repeat="rate in ratesByMeArray">
	                <div class="panel-body">
	                  <header class="text-left">
	                    <div class="comment-user"><i class="fa fa-user"></i>
	                    You gave <a href="/profile/@{{rate[0].user.id}}">@{{rate[0].user.fname}}</a> this feedback
	                    </div>
	                  </header>
	                  <div class="comment-post">
	                  <hr>
	        			<center>
	                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> @{{rate[0].updated_at | relativeDate}}</time>
	        			</center>
	        			<br>
	        			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" ng-repeat="trait in rate">	        				
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<img ng-src="/traits-icons/@{{trait.trait_name}}.png" width="25px" style="padding-right: 10px">
								<span class="overflowed">@{{trait.trait_name}}</span>
							</div>
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
								<jk-rating-stars max-rating="5" rating="trait.rate / 5" read-only="1">
								</jk-rating-stars>
							</div>
	        			</div>

	                  </div>
	                </div>
	              	<div class="panel-footer">
	                  <p>You left a note:</p>
	                  <hr ng-show="rate[0].review">
	                  <div class="me">
	                  	<p>
	                  	@{{rate[0].review}}
	                  	<span ng-show="rate[0].review" style="font-style: italic; color: grey"> - @{{rate[0].updated_at | relativeDate}}</span>
							<span ng-show="!rate[0].review && !rate[0].chats" style='font-style: italic; color: grey'>You haven't left a note!</span>
	                  	</p>
	                  </div>
	                  {{-- @{{myRatesArray}} --}}
	                  <div ng-init="rate[0].chats = sortChats(rate[0].chats)" ng-repeat="chat in rate[0].chats">
		                  <div ng-class="chat.from_id == {!!Auth::id()!!} ? 'me' : 'him'"><p> 
			                  @{{chat.message}}
			                  <span style='font-style: italic; color: grey'>
			                  	- @{{chat.updated_at | relativeDate}}
			                  </span>
		                  </p></div>
	                  </div>
	                  <input ng-keypress="sendChat({!!Auth::id()!!}, rate[0].user_id, {!!Auth::id()!!}, rate[0].myMessage, $event)" ng-model="rate[0].myMessage" type="text" class="form-control" placeholder="Reply.." id="chat">
	              	</div>
	              </div>
		</div>
	</div>
</div>
@stop
