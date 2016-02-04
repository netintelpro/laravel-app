@include('header')
<section id="pageContainer" class="section ">
	<div class="container">

			<div class="text-center"><br>
				@if(isset($pic))
					<img src="{{$pic}}"><br>

		      			
				@endif
				@include('fb-like')
		    		<h2>{{$title}}</a></h2><br>
		                <div class="excerpt">
				@if(isset($content))
		      			{{$content}}
				@else {{$summary}}
				@endif
		    		</div>
		          	<div class="tags">
		      			<a href="{{$url}}">Source</a>
		    		</div>
        		</div>

	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
