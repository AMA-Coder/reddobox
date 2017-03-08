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
							@if (isset($rate['social']))
		                		<div>
		                			<center>
			                			<h4>Social box</h4>
				                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{$rate['social'][0]['updated_at']->diffForHumans()}}</time>
		                			</center>
				                    @foreach ($rate['social'] as $traits)
				                    	@if($traits['rate'] != 0) 
											<p>{!! $traits['traitName'] !!} : {!! $traits['rate'] !!}%
							                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
							                    <div style="margin-top: -10px; height: 10px; width: {{$traits['rate']}}%;" class="bg"></div>
											</p>
				                    	@endif
				                    @endforeach
				                    <p><b>Your friend left a note says: </b><p style="color: grey; padding-left: 20px"> {{$rate['social'][0]['review']}} </p></p>
		                		</div>
		                		<hr>
		                	@endif
							@if (isset($rate['personal']))
		                		<div>
		                			<center>
			                			<h4>Personal box</h4>
				                    	<time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> {{$rate['personal'][0]['updated_at']->diffForHumans()}}</time>
		                			</center>
				                    @foreach ($rate['personal'] as $traits)
				                    	@if($traits['rate'] != 0) 
											<p>{!! $traits['traitName'] !!} : {!! $traits['rate'] !!}%
							                    <div style="display: block; height: 10px; width: 100%; background: lightgrey"></div>
							                    <div style="margin-top: -10px; height: 10px; width: {{$traits['rate']}}%;" class="bg"></div>
											</p>
				                    	@endif
				                    @endforeach
				                    <p><b>Your friend left a note says: </b><p style="color: grey; padding-left: 20px"> {{$rate['personal'][0]['review']}} </p></p>
		                		</div>
			                @endif
	                  </div>
	                </div>
	              </div>
	            </div>
			@endforeach

		@endif
	</div>
@stop