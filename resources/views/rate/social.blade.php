@extends('layouts.master')

@section('content')
@if (Auth::user()->isFriendWith($user))
  <div class="container">
  <div id="profilecontent">
    <div class="row">
  <div class="col-sm-6 col-md-3 my">
    <div class="thumbnail">
    <img src="{{secure_url('uploads/images/')}}/{{$user->avatar}}" width="250px" alt="...">
    <div class="caption">
    <center><h3><a href="/profile/{{$user->id}}">{{$user->fname}} {{$user->lname}}</h3></a></center>
        {{-- <ul style="list-style:none;padding-left:0">
        <li id="menu">
          <md-button href="/rate/social/{{$user->id}}" class="md-raised md-primary activebtn" style="background-color:#1D7F8D;">
            social evaluation
            </md-button>
            </li>
            <li>
            <md-button href="/rate/social/{{$user->id}}" class="md-raised md-primary mybtn" style="background-color:#272525;">
             social evaluation
          </md-button>
          </li>
          <li>
            <md-button href="/rate/professional/{{$user->id}}" class="md-raised md-primary mybtn" style="background-color:#272525;">
            Professional evaluation
          </md-button>
          </li>
          </ul> --}}
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var from_id = {{Auth::id()}};
    var user_id = {{$user->id}};
  </script>
<div class="col-md-9 col-sm-6"  ng-controller="socialRateCtrl">
<div style=" height: auto; background-color:#edebeb;padding: 10px;">
<h3>Reddo {{$user->fname}} socially</h3>
<center>
  Your overall rate now is @{{total}}%
</center>
    <div ng-repeat="trait in social_traits">
      <md-checkbox class="checkBoxColor" ng-model="bool[trait.id]" ng-click="zeroRate(trait.id)"><h4>@{{trait.name}}</h4></md-checkbox>
      <md-slider-container ng-disabled="!bool[trait.id]">
      <div flex="10" layout="" layout-align="center center">
        <span class="md-body-1" ng-show="bool[trait.id]">@{{ss[trait.id]}}%</span>
      </div>
        <md-slider step="5" id="red-slider" ng-model="ss[trait.id]" ng-change="changeBool(trait.id)" aria-label="red" flex="" ng-readonly="readonly"></md-slider>
      </md-slider-container>
    </div>
    <hr>
      <textarea onkeyup="checkRtl(this)" ng-model="review" class="form-control" rows="5" required="required" placeholder="Leave a note.."></textarea>
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
    <center>
    <hr>
    <button type="button" id="social_submit" class="btn bg color btn-lg" id="load" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processing">Reddo</button>
    </center>
    <hr>
      </div> </div>
    </div>
</div>

  </div>
@else
<center style="min-height: 70%">
  <h1>
    You're not friends.
  </h1>
</center>
@endif
@stop