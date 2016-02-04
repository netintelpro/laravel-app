@include('header')
<section id="pageContainer" class="section ">
	<div class="container">

			<div class="text-center"><br>

		                <div class="excerpt">
					<div class="questions-chart"  id="{{$question->id}}"></div>
					<div style="margin-right: 30%;" class="col-sm-4 center-block">@include('fb-like')</div>
		    		</div>
		          	
        		</div>

	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
