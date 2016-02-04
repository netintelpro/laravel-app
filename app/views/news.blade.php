@include('header')

	<section id="pageContainer" class="section">
		<div class="container">
		<section id="results">
		      	<h2 class="center-title"><span>{{ucwords ($issue_name)}}</span></h2>
			@foreach ($news as $article)
				<div class="col-sm-4">
				     	<div class="box-item">
					    @if(isset($article->image->url))
					    	<div class="article" title="" style="background-image: url('{{$article->image->url}}');"></div>
					    @endif
					    <h3><a href="{{URL::route('article')}}{{'?url='.$article->unescapedUrl}}@if(isset($article->image->url)){{'&pic='.$article->image->url}}@endif{{'&summary='.$article->content}}{{'&title='.$article->title}}">{{$article->title}}</a></h3><br>
					    
					    <div class="excerpt">
					      <p>{{$article->content}}</p>
					    </div>
					    <div class="tags">
		      					<a href="{{URL::route('article')}}{{'?url='.$article->unescapedUrl}}@if(isset($article->image->url)){{'&pic='.$article->image->url}}@endif{{'&summary='.$article->content}}{{'&title='.$article->title}}">Read more...</a>
		    				</div>	
					</div>			    
				</div>
			@endforeach
		</section>
		</div>  
	</section>

@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
