@if(Request::get('cat') !== 'social' && Request::get('cat') !== 'personal')
	{{abort(404)}}
@endif

@extends('layouts.master')

@section('content')
	<div class="container"  style="min-height: 580px;">
		@if (count($rates) == 0)
			<center>
				<p>You don't have any rates/reviews, yet.</p>
				<p>Come back later</p>
			</center>
		@else
			@foreach ($rates as $rate)
	            <div class="col-xs-12">
	              <div class="panel panel-default arrow left">
	                <div class="panel-body">
	                  <header class="text-left">
	                    <div class="comment-user"><i class="fa fa-user"></i>
	                    One of your friends gave you this feedback
	                    </div>
	                  </header>
	                  <div class="comment-post">
	                  <hr>
	                  	@if (Request::get('cat') == 'social')
		                		<div>
		                			<center>
			                			<h4>Social box</h4>
				                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{count($rate) ? $rate[0]['updated_at']->diffForHumans() : ''}}</time>
		                			</center>
		                			@if (count($rate))
					                    @foreach ($rate as $traits)
					                    	@if($traits['rate'] != 0) 
												<p>{!! $traits['traitName'] !!} : {!! $traits['rate'] !!}%
								                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
								                    <div style="margin-top: -10px; height: 10px; width: {{$traits['rate']}}%;" class="bg"></div>
												</p>
					                    	@endif
					                    @endforeach
					                    <p><b>Your friend left a note says: </b><p style="color: grey; padding-left: 20px"> {{$rate[0]['review']}} </p></p>
		                			@endif
		                		</div>
		                		<hr>
	                  	@elseif(Request::get('cat') == 'personal')
							@if (isset($rate))
		                		<div>
		                			<center>
			                			<h4>Personal box</h4>
				                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{$rate[0]['updated_at']->diffForHumans()}}</time>
		                			</center>
				                    @foreach ($rate as $traits)
				                    	@if($traits['rate'] != 0) 
											<p>{!! $traits['traitName'] !!} : {!! $traits['rate'] !!}%
							                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
							                    <div style="margin-top: -10px; height: 10px; width: {{$traits['rate']}}%;" class="bg"></div>
											</p>
				                    	@endif
				                    @endforeach
				                    <p><b>Your friend left a note says: </b><p style="color: grey; padding-left: 20px"> {{$rate[0]['review']}} </p></p>
		                		</div>
			                @endif
	                  	@endif
	                  </div>
	                </div>
	              </div>
	            </div>
			@endforeach

		@endif
	</div>
@stop