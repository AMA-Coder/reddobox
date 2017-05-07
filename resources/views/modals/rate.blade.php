<div class="modal fade" id="personal-rate" ng-controller="rateCtrl">
	<div class="modal-dialog" style="width: 100% !important">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Reddo {{$user->fname}} personally!</h4>
			</div>
			<div class="modal-body">
				<div class="container">
					<div class="row">
						<div ng-repeat="trait in traits">
							<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6" style="padding-bottom: 20px">
								<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
								<img ng-src="/traits-icons/@{{trait.name}}.png" width="30px" style="padding-right: 10px">
								<span>@{{trait.name}}</span>
								</div>
								<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
									<jk-rating-stars max-rating="5" rating="ratings[trait.id]" read-only="ctrl.readOnly" on-rating="onRating(rating, trait)" >
									</jk-rating-stars>
								</div>
							</div>
						</div>
					</div>
					<textarea  onkeyup="checkRtl(this)" ng-model="review" class="form-control" rows="5" required="required" placeholder="Leave a note.."></textarea>
					<style>
						.rtl {
					    direction: rtl; 
					    text-align: right;
					    unicode-bidi: bidi-override;
					}

					.ltr {
					    direction: ltr; 
					    text-align: left;
					    unicode-bidi: bidi-override;
					}
					</style>
					<script>
					function checkRtl( field ) {
						var character = field.value[0];
					  var RTL = ['ا','ب','پ','ت','س','ج','چ','ح','خ','د','ذ','ر','ز','ژ','س','ش','ص','ض','ط','ظ','ع','غ','ف','ق','ک','گ','ل','م','ن','و','ه','ی'];
					  if(RTL.indexOf( character ) > -1){
					  	field.className = "rtl form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched";
					  }else{
					  	field.className = "ltr form-control ng-pristine ng-empty ng-invalid ng-invalid-required ng-touched";
					  }
					};
					</script>
				</div>
			</div>
			<div class="modal-footer">
				<center>
					<button type="button" id="personal_submit" class="btn bg color btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing" style="width: 20%">Submit review</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</center>
			</div>
		</div>
	</div>
</div>

<script>
	app.controller('rateCtrl', function ($scope, $http) {
		$scope.user = {!!$user!!};

		$http.get('/rate/get_traits/personal').then(function(res) {
			$scope.traits = res.data.traits;
		})

		$scope.ratings = [];
		$scope.review = '';

		$scope.onRating = function (rating, trait) {
			if(rating == 0) {
				delete $scope.ratings[trait.id];
			}
			console.log($scope.ratings)
		}

		$('#personal_submit').on('click', function() {
			  var $this = $(this);
			$this.button('loading');

          angular.forEach($scope.ratings, function(v, k) {
          	$scope.ratings[k] = v * 5;
          })

			$http.post('/rate/personal', {
			    review: $scope.review, 
			    id: $scope.user.id,
			    rates: $scope.ratings
			}).then(function (data) {

	          angular.forEach($scope.ratings, function(v, k) {
	          	$scope.ratings[k] = v / 5;
	          })
			  if(data.data.check) {
			    $this.button('reset');
			        swal({
			          title: 'Done!',
			        }, function () {
			        	$('#personal-rate').modal('hide');
			        });
			        $scope.notify($scope.user.id, 'Someone rated you personally!');
			    }else{
			        swal('Failed, Try again later!');
			    }
			})
		});

		$scope.notify = function (url_id, text) {
			$http.post('/notify', {
				from_id: {!!Auth::id()!!},
				user_id: $scope.user.id,
				text: text,
				url: '/rate/details/',
			})
		}

      $http.post('/rate/get', {
        from_id: {!!Auth::id()!!},
        user_id: $scope.user.id,
        category: 'personal',
      }).then(function(result) {
        if(result.data.rate) {
          $scope.social = result.data.rate;
          $scope.ratings = [];
          var total = [];
          angular.forEach($scope.social, function(v, k) {
            $scope.ratings[v.rate_trait_id] = v.rate / 5;
            if(v.rate != 0) {
                total.push(v.rate);
            }
            $scope.review = v.review;
          })

          $scope.total = 0;
          var counter = 0;

          if(total.length == 0) {
            $scope.total = 0;
          }else{
            for (var i = total.length - 1; i >= 0; i--) {
              $scope.total = $scope.total + total[i];
              counter++;
            }

            $scope.total = Math.round($scope.total/counter);
            console.log($scope.total)
          }
        }
      })

	})
</script>