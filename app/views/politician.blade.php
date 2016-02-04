@include('header')
  <section id="pageContainer" class="section">
  <section id="intro">
    <div class="container">
      <div class="row">
        
        <div class="col-sm-3">
          <div class="politician" title="{{$politician->full_name}}" style="background-image: url('{{$politician->pic_url}}');">
            <span class="politician-inner" >

              <span class="sprite 
		@if($politician->party=='Democrat') 
			dem-lg	
		 
		@elseif ($politician->party=='Republican') rep-lg
		@endif"></span>
              <span class="sprite @if($politician->rank > 0)trend-up-stat 
		@else trend-down-stat
		@endif lg" id="trend">{{$politician->rank}}</span>
            </span>
          </div>
        </div>
        
        <div class="col-sm-3">
          <h1>{{$politician->full_name}}</h1>
 	@if(Auth::check())
	  @if(Auth::user()->role=='admin') 
	  	<h2><a href="{{Route('edit-politician', $politician->full_name)}}">EDIT PROFILE</a></h2>
	  @endif
	@endif
          <h2>{{$politician->office}}</h2>
          <h3>{{$politician->district}}</h3>
          
          <!-- http://plugins.krajee.com/star-rating/demo -->
          <form class="ratings" > 
            <input id="input-{{$politician->id}}" class="rating" data-min="0"  data-max="5"  data-stars="5"    value="{{5* ( $politician->rank/DB::table('politicians')->max('rank'))}}"  data-readonly="true" data-show-clear="false" data-show-caption="false" type="number">    
          </form>
	@include('fb-like')
	 @if(Auth::check())
		 <button class="follow btn btn-lg" id = "{{$politician->id}}">
		@if(PoliticianFollow::where(function($query) use ($politician)
		    {
		        $query->where('politician_id', '=', $politician->id)
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
          <div id="{{$politician->id}}" class="politicians-chart"></div>
        </div>
	@if(true)
	@if(Auth::check())
        <div class="row issue-row">
	@foreach ($issues->take(3) as $issue)
			<div class="col-xs-4 issue-box" >
				  <div class="box" style="border-bottom-left-radius: 8px;
						border-bottom-right-radius: 8px;
						border-top-left-radius: 8px;
						border-top-right-radius: 8px;
						box-shadow: rgb(153, 153, 153) 0px 0px 3px 0px;">
					<header style="background-color: rgb(235, 226, 195);padding: 0px 0px 0px 10px;">
					<h3 style="border-color:transparent;">{{ucwords ($issue->issue_name)}}</h3>

					<?php 
					$date = new DateTime;
					$date->modify('-1 hour');
					$formatted_date = $date->format('Y-m-d H:i:s');
			

					$sum = Rating::where('user_id','=',Auth::user()->id)
					->where('politician_id','=',$politician->id)
					->where('issue_id','=',$issue->id)->where('created_at','>=',$formatted_date)->sum('value');

					?>
					
						<form action="{{URL::route('issue-vote')}}" method="post" 
						style="width: 45px;margin-top: -35px;float: right;"class="form" enctype="multipart/form-data" id="form-issue-vote">
							<input type="hidden" value="{{$politician->id}}" name="politician_id" id="politician_id">
				 			<input type="hidden" value="{{$issue->id}}" name="issue_id" id="issue_id">  
							<input type="hidden" value="{{Auth::user()->id}}" name="user_id" id="user_id">      
							<input type="hidden" value="{{Auth::user()->id}}" name="vote" id="vote">
							<span class="thumbs thumbs{{$issue->id}} above-fold-thumbs"  id='thumbs{{$issue->id}}'>
							<a id="{{$politician->id}}-{{$issue->id}}" class="above-fold-thumbs-up sprite @if($sum==1){{'thumbs-up-grey'}} @else{{'thumbs-up'}}@endif" ></a>
							<a id="{{$politician->id}}-{{$issue->id}}" class="above-fold-thumbs-down sprite @if($sum== -1){{'thumbs-down-grey'}}@else{{'thumbs-down'}}@endif" ></a>
						</form>
					
					 </header>
				 </div>
			</div>
	@endforeach
	</div>
	@endif
	@endif
      </div>
    </div>
  </section>

   <section id="trending">
    <div class="container">
<div class="row">
	<div class="col-sm-6 ">
	      <h2>Trending Issues</h2>
	      
	      <div class="row">
		
		<div id="word-cloud" class="col-sm-12"></div>
	
	      </div>
	</div>


	<div class="col-sm-6 ">
		<h2>Be iRate!</h2>
		      <div class="row">
		       <div id="rant-box" class=" pull-right">
			<form action="{{URL::route('rant')}}" method="post" class="form" enctype="multipart/form-data" role="form">
			<textarea class="form-control" rows="6" cols="100" id="rant" name="rant" placeholder="What's on your mind?"></textarea>
		          <div class="ui-widget">      
				@if($errors->has('auto-politician'))
								<label style="color:red;">{{$errors->first('auto-politician')}}</label>
				@endif
				<input type="hidden" name="auto-politician" id="auto-politician" value="{{$politician->full_name}}"  />
			 </div>

			<button class="btn pull-right">Submit</button></div>
			</form>
		      </div>
		</div> 
	</div>
</div>
  </section>
   @if(Auth::check())
  <section id="issues">
    <div class="container">
      <h2 class="center-title"><span>Vote on More Issues</span></h2>
      <h3>How does {{$politician->full_name}} handle these issues?</h3>
      
      <div class="row issue-row" id="issues-rows">
	<?php $i=0;?>
	<?php $x=0;?>
	<?php $article_index=0;?>
	
	@foreach ($issues as $issue)
		<?php $search_results = $issue->googleNews($politician->full_name) ;?>
		@if($search_results != null)
			<?php $x++;?>

			@if(($x%3)==1)<div class="row" id="issue-row-{{($x+2)/3}}">@endif

			<div class="col-xs-4 issue-box" >
				  <div class="box">
					<header>
					<h3>{{ucwords ($issue->issue_name)}}</h3>

					<?php 
					$date = new DateTime;
					$date->modify('-1 hour');
					$formatted_date = $date->format('Y-m-d H:i:s');
			

					$sum = Rating::where('user_id','=',Auth::user()->id)
					->where('politician_id','=',$politician->id)
					->where('issue_id','=',$issue->id)->where('created_at','>=',$formatted_date)->sum('value');

					?>
					
						<form action="{{URL::route('issue-vote')}}" method="post" class="form" enctype="multipart/form-data" id="form-issue-vote">
							<input type="hidden" value="{{$politician->id}}" name="politician_id" id="politician_id">
				 			<input type="hidden" value="{{$issue->id}}" name="issue_id" id="issue_id">  
							<input type="hidden" value="{{Auth::user()->id}}" name="user_id" id="user_id">      
							<input type="hidden" value="{{Auth::user()->id}}" name="vote" id="vote">
							<span class="thumbs thumbs{{$issue->id}}" id='thumbs{{$issue->id}}'>
							<a id="{{$politician->id}}-{{$issue->id}}" class="sprite  @if($sum==1){{'thumbs-up-grey'}} @else{{'thumbs-up'}}@endif" ></a>
							<a id="{{$politician->id}}-{{$issue->id}}" class="sprite @if($sum== -1){{'thumbs-down-grey'}}@else{{'thumbs-down'}}@endif" ></a>
						</form>
					
					 </header>
					 <div class="description">
			
						@if($search_results != null)
							<?php $result_count = 0;?>
							@foreach($search_results as $results)
			
								@if(($results != null)&&($result_count <=2 ))
								<div  >
					      				<p><a onclick="readNews({{$article_index}});"  >{{$results->title}}</a> <br>
									<span class="date">{{substr($results->publishedDate,0,16)}}</span></p>
									<p class="news_content" id="news_content{{$article_index++}}">{{$results->content}}<a target="_blank" href="{{URL::route('article')}}{{'?url='.$results->unescapedUrl}}@if(isset($results->image->url)){{'&pic='.$results->image->url}}@endif{{'&summary='.$results->content}}{{'&title='.$results->title}}"><i>continued</i></a></p><br/>
								</div>	
								<?php $result_count++;?>				
								@endif
							@endforeach
						@endif        
					    </div>
				  </div>
			</div>
			@if(($x%3)==0)</div>@endif
		@endif
	@endforeach
	@if(($x%3)!=0)</div>@endif
	</div>
	<input id="issue_count" value={{$x}} type="hidden">
	<input id="article_index" value={{$article_index}} type="hidden">
	<input id="user" value="{{Auth::user()->id}}" type="hidden">
	@if($issues_not_followed != null)
		<div class="row">
		  <div class="col-sm-3">
		    <a  id="show-more-issues" class="btn btn-lg pull-right">Show More Issues</a>
		  </div>
		  <div class="col-sm-7">
			@foreach($issues_not_followed as $issue)
			<div class="btn-issue">	<a id="{{$politician->id}}-{{$issue->id}}" class="btn btn-tag">{{ucwords ($issue->issue_name)}}</a> </div>
		 	@endforeach
		  </div>
		</div>
	@endif
  </section>
@else
 <section id="issues">
    <div class="container">
      <h2 class="center-title"><span>Vote on More Issues</span></h2>
      <h3>How does {{$politician->full_name}} handle these issues?</h3>
      
      <div class="row" id="issues-rows">
	<?php $i=0;?>
	<?php $x=0;?>
	<?php $article_index=0;?>
	
	@foreach (Issue::all() as $issue)
		<?php $search_results = $issue->googleNews($politician->full_name) ;?>
		@if($search_results != null)
			<?php $x++;?>

			@if(($x%3)==1)<div class="row" id="issue-row-{{($x+2)/3}}">@endif

			<div class="col-xs-4 issue-box" >
				  <div class="box">
					<header>
					<h3>{{ucwords ($issue->issue_name)}}</h3>

					 </header>
					 <div class="description">
			
						@if($search_results != null)
							<?php $result_count = 0;?>
							@foreach($search_results as $results)
			
								@if(($results != null)&&($result_count <=2 ))
								<div  >
					      				<p><a onclick="readNews({{$article_index}});"  >{{$results->title}}</a> <br>
									<span class="date">{{substr($results->publishedDate,0,16)}}</span></p>
									<p class="news_content" id="news_content{{$article_index++}}">{{$results->content}}<a target="_blank" href="{{URL::route('article')}}{{'?url='.$results->unescapedUrl}}@if(isset($results->image->url)){{'&pic='.$results->image->url}}@endif{{'&summary='.$results->content}}{{'&title='.$results->title}}"><i>continued</i></a></p><br/>
								</div>	
								<?php $result_count++;?>				
								@endif
							@endforeach
						@endif        
					    </div>
				  </div>
			</div>
			@if(($x%3)==0)</div>@endif
		@endif
	@endforeach
	@if(($x%3)!=0)</div>@endif
	</div>
	
  </section>
@endif
  
  
  <section id="recommended">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <h3>You may be interested in:</h3>
        </div>
	<div class="col-sm-9">
	@foreach(Politician::where('party', '=', $politician->party)->take(4)->get() as $suggestion)
	  <a href="{{URL::route('profile-politician',$suggestion->full_name)}}" class="btn btn-tag">{{$suggestion->full_name}}</a> 
        @endforeach 
        </div>
    </div>
  </section>
  @if(Auth::check())
  <section id="comments">
    <div class="container">
      <h2>Comments <span class="label label-info">{{$politician->comments->count()}}</span></h2>
      
      <div class="row" id="row-0">
        
        <div class="col-sm-12">



		<div class="form-group">
	            <input type="hidden" value="0" name="parent_id"  id="parent_id">  
          
		    <input type="hidden" value="{{$politician->id}}" name="politician_id">                  
              <textarea  type="text" class="form-control" id="textarea-0-{{$politician->id}}" placeholder="What's on your mind?"></textarea>
            </div>
            <button type="submit" class="btn pull-right parent-comment-button" id="0-{{$politician->id}}">Submit</button>

        </div>        

      </div>
      
        <ul class="list-group" id="list-group-0">
		@foreach($comments as $comment)
		 <li class="list-group-item"><a class ="anchor" id="{{$comment->user->username.'-'.$comment->id}}" ></a>
                <div class="row" id="row-{{$comment->id}}">
                    <div class="col-sm-2">
                        <a  href="{{URL::route('profile-user',$comment->user->username)}}"><img src="{{$comment->user->pic_url}}" class="img-circle img-responsive" alt="" /></a>
                    </div>
                        <input type="hidden" value="{{$comment->id}}" name="comment_id" id="comment_id">
                    <div class="col-sm-10">
                        <div class="mic-info">
                            <a href="{{URL::route('profile-user',$comment->user->username)}}">
			{{$comment->user->username}}</a> <span class="date"> on {{date( 'D M d, Y',strtotime( $comment->created_at))}}</span>
                        </div>
                        <blockquote  class="comment-text" >
			{{$comment->content}}
                        </blockquote>
                        
                        <div class="row comment-meta">
                          <div class="col-sm-2">
                            <div class="voting">
                              <a class="vote-up" >
			      	<span class="sprite vote-up vote-up-sprite" id="up-{{$comment->id}}"></span>
			      </a>
                              <span id="rank-{{$comment->id}}">{{$comment->rank}}</span>
			      <a class="vote-down" >
			      	<span class="sprite vote-down vote-down-sprite" id="down-{{$comment->id}}"></span> 
			      </a>                                             
                            </div>
                          </div> 
                          <div class="col-sm-8">
                            <div class="topics">
                              <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Healthcare</a> 
                              <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Economy</a>
                              <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Immigration</a>
                            </div>
                          </div>
                          <div class="col-sm-2">
			    <?php $reply_count = $comment->replies()->count();?>
                            <a class="replies pull-right" id="{{$comment->id}}-{{$politician->id}}">{{$reply_count}}@if($reply_count==1){{' reply'}}@else{{' replies'}}@endif</a> 
                          </div
                        </div>
                     
                    </div>
                </div>
            </li>

		@endforeach
          
          
      
        </ul>
     


    </div>
  </section>
  
 @endif 

      
  
  
  


</section><!-- #pageContainer -->
 <script>
jQuery(document).ready(function() 
{
$( "body" ).removeClass( "home-page" ).addClass( "profile-page @if($politician->party=='Democrat'){{'democrat'}}@endif
@if($politician->party=='Republican'){{'republican'}}@endif" );




});
</script> 		
@include('footer_chart',array('chart'=>'true','issue_tag_cloud'=>$issue_tag_cloud,'democrat_chart_data'=>$democrat_chart_data,'republican_chart_data'=>$republican_chart_data))

