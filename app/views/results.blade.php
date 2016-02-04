@include('header')
<section id="pageContainer" class="section">
	<section id="results">
	   <div class="container">
	      <h2 class="center-title"><span>SEARCH RESULTS</span></h2>
		@if(($politicians !=null) && ($politicians->count()))
			<h2 class="center-title " style="margin-top: 40px;"><span>Politicians</span></h2>
		      		@foreach ($politicians as $politician) 
				<div class="row">
		
				<div class="col-sm-3">
				  <div class="politician" title="{{$politician->full_name}}" style="background-image: url('{{$politician->pic_url}}');">
				<a href="{{URL::route('profile-politician',$politician->full_name)}}">
				    <span class="politician-inner" >
					<span class="sprite 
					@if($politician->party=='Democrat') 
						dem-lg	
					 
					@elseif ($politician->party=='Republican') rep-lg
					@endif"></span>
		
				      <span class="sprite 

					@if(Politician::find($politician->id)->ratings->sum('value') > 0)trend-up-stat 
					@else trend-down-stat
					@endif
			lg">{{Politician::find($politician->id)->ratings->sum('value')}}</span>
				    </span>
			      </a>    </div>
				</div>
		
				<div class="col-sm-3">
				  <h1><a href="{{URL::route('profile-politician',$politician->full_name)}}">{{$politician->full_name}}</a></h1>
				  <h2>{{$politician->office}}</h2>
				  <h3>{{$politician->district}}</h3>
				  
				  <!-- http://plugins.krajee.com/star-rating/demo -->
				  <form class="ratings"  role="form">          
				    
				<input style="display: none;" id="input-2" class="rating" data-show-clear="false" data-show-caption="false" type="number">    
				  </form>
				  <form action="{{URL::route('follow-politician')}}" method="post" class="form" enctype="multipart/form-data" >
				    <input type="hidden" value="{{$politician->id}}" name="politician_id"> 
				  
				</form>
				</div>
		
				<div class="col-sm-6">
				  <div class="politicians-chart" id="{{$politician->id}}"></div>
				</div>
		
			      </div>
			@endforeach
			
		@endif
		@if(isset($users))
		@if(($users !=null) && ($users->count()))
			<h2 class="center-title" style="margin-top: 40px;"><span>Users</span></h2>
		      		@foreach ($users as $user) 
				<div class="row">
		
				<div class="col-sm-3">
				  <div class="politician" title="{{$user->username}}" style="background-image: url('{{$user->pic_url}}');">
				<a href="{{URL::route('profile-user',$user->username)}}">
				    <span class="politician-inner" >
					<span class="sprite 
					@if($user->party=='Democrat') 
						dem-lg	
					 
					@elseif ($user->party=='Republican') rep-lg
					@endif"></span>
		
				     
			      </a>    </div>
				</div>
		
				<div class="col-sm-3">
				  <h1><a href="{{URL::route('profile-user',$user->username)}}">{{$user->username}}</a></h1>
				  <h2>{{$user->city}}</h2>
				  <h3>{{$user->state}}</h3>
				  
				  @if(Auth::check())
					 <button class="follow btn btn-lg" id="{{$user->id}}">
						@if(UserFollow::where(function($query) use ($user)
					    {
						$query->where('following_id', '=', $user->id)
						      ->where('user_id', '=', Auth::user()->id);
					    })->count()
					   )
						{{'UN-FOLLOW'}}
						@else
						{{'FOLLOW'}}
						@endif
				

				 	</button>
				@endif
				</div>
		
				<div class="col-sm-6">
				 <div id="{{$user->id}}" class="users-chart"></div>
				</div>
		
			      </div>
			@endforeach
		@endif	
		@endif

     
		@if($issue !=null)
			<h2 class="center-title" style="margin-top: 40px;"><span>{{ucwords ($issue->issue_name)}}</span></h2>
			<div class="row">
		      		@foreach ($issue->gNews() as $article) 
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
			</div>
		
		@endif
		@if($news !=null)
			<h2 class="center-title" style="margin-top: 40px;"><span>News</span></h2>
			<div class="row">
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
			</div>
		
		@endif
		@if((($politicians ==null) || ($politicians->count()==0)) && ($issue ==null) &&($news ==null) &&(($users ==null) || ($users->count()==0)))
				<div style="text-align:center;"><h1>No Results Found. Try Search Again</h1></div>
		@endif
	    </div>
	</section>
   


</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
