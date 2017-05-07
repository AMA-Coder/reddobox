@extends('layouts.master')

@section('content')
<script type="text/javascript">
	app.controller('myPersonalCtrl', function($scope, $http) {
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

	    $scope.myRates = {!!$myRatesGrouped!!};
	    $scope.myRatesArray = sort($scope.myRates);

	    $scope.ratesByMe = {!!$ratesDoneByMe!!};
	    $scope.ratesByMeArray = sort($scope.ratesByMe);

	    setInterval(function () {
		    $http.post('/rate/getPersonal').then(function(res) {
			    $scope.myRates = res.data.myRatesGrouped;
			    $scope.myRatesArray = sort($scope.myRates);

			    $scope.ratesByMe = res.data.ratesDoneByMe;
			    $scope.ratesByMeArray = sort($scope.ratesByMe);
		    })
	    }, 10000)

	})
</script>
<div class="container"  style="min-height: 580px;" ng-controller="myPersonalCtrl">
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
	              	</div>
	              </div>

		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<center><h2>Reddo</h2></center>
	              <div class="panel panel-default arrow left" ng-repeat="rate in ratesByMeArray">
	                <div class="panel-body" ng-init="log(rate.updated_at)">
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
	                  <p>Your friend left a note:</p>
	              	</div>
	              </div>
		</div>
	</div>
</div>
@stop
