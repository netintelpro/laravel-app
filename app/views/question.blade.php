@include('header')
<section id="pageContainer" class="section ">
	<div class="container">

			<div class="text-center"><br>
	   		<h2>{{$question->content}}</a></h2><br>
		                <div class="excerpt">
			<form action="" method="post" class="form" id="" enctype="multipart/form-data" role="form">
			<input type="hidden" value="{{$question->id}}">
				<div class="col-sm-4 center-block">
				@foreach($question->answers as $answer)
				<div class="row" class="text-center" style="width: 60%;">
					<div class="pull-left">	
						<input type="radio" name="answer_id" id="answer_id" value="{{$answer->id}}" >
					</div>
					<div class="pull-right">	
						<label >{{$answer->content}}</label>
					</div>
				</div>
				@endforeach
				</div><br>
				<div class="col-sm-4 center-block">
					<button class="btn btn-lg btn-block light" id="" type="submit">Vote</button>
				</div>		<br><br>		
				</form>
				@include('fb-like')
		    		</div>
		          	
        		</div>

	</div>
</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
