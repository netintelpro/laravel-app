@include('header')
<section id="pageContainer" class="section">

 
  <section id="top-politicians">
    <div class="container">
      
        <div class="col-sm-3" id="obama">
          <div class="politician" title="Barack Obama" style="background-image: url('/assets/images/politicians/obama.jpg');"><!-- color on the outside -->
            <a href="{{URL::route('profile-politician','Barack Obama')}}"  class="politician-inner" style="background-image: url('/assets/images/politicians/obama-bw.jpg');"><!-- black and white on the inside -->
              <span class="sprite dem-lg"></span>
              <span href="{{URL::route('profile-politician','Barack Obama')}}" class="btn btn-lg light vote">Vote</span>
              <span class="sprite @if(Politician::where('full_name','=','Barack Obama')->first()->ratings->sum('value') > 0)trend-up-stat 
		@else trend-down-stat
		@endif">{{Politician::where('full_name','=','Barack Obama')->first()->ratings->sum('value')}}</span>
            </a>
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="politician" title="Nancy Pelosi" style="background-image: url('/assets/images/politicians/pelosi.jpg');">
            <a href="{{URL::route('profile-politician','Nancy Pelosi')}}"  class="politician-inner" style="background-image: url('/assets/images/politicians/pelosi-bw.jpg');">
              <span class="sprite dem-lg"></span>
              <span href="{{URL::route('profile-politician','Nancy Pelosi')}}" class="btn btn-lg light vote">Vote</span>
              <span class="sprite @if(Politician::where('full_name','=','Nancy Pelosi')->first()->ratings->sum('value') > 0)trend-up-stat 
		@else trend-down-stat
		@endif">{{Politician::where('full_name','=','Nancy Pelosi')->first()->ratings->sum('value')}}</span>
            </a>
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="politician" title="Mitt Romney" style="background-image: url('/assets/images/politicians/romney.jpg');">
            <a href="{{URL::route('profile-politician','Mitt Romney')}}" n class="politician-inner" style="background-image: url('/assets/images/politicians/romney-bw.jpg');">
              <span class="sprite rep-lg"></span>
              <span href="{{URL::route('profile-politician','Mitt Romney')}}" class="btn btn-lg light vote">Vote</span>
              <span class="sprite @if(Politician::where('full_name','=','Mitt Romney')->first()->ratings->sum('value') > 0)trend-up-stat 
		@else trend-down-stat
		@endif">{{Politician::where('full_name','=','Mitt Romney')->first()->ratings->sum('value')}}</span>
            </a>
          </div>
        </div>
        
        <div class="col-sm-3">
          <div class="politician" title="John McCain" style="background-image: url('/assets/images/politicians/mccain.jpg');">
            <a href="{{URL::route('profile-politician','John McCain')}}"  class="politician-inner" style="background-image: url('/assets/images/politicians/mccain-bw.jpg');">
              <span class="sprite rep-lg"></span>
              <span href="{{URL::route('profile-politician','John McCain')}}" class="btn btn-lg light vote">Vote</span>
              <span class="sprite @if(Politician::where('full_name','=','John McCain')->first()->ratings->sum('value') > 0)trend-up-stat 
		@else trend-down-stat
		@endif">{{Politician::where('full_name','=','John McCain')->first()->ratings->sum('value')}}</span>
            </a>
          </div>
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
				<input class="form-control ui-autocomplete-input" autocomplete="off" name="auto-politician" id="auto-politician" 
				placeholder="Which Politician?" type="text"  />
			 </div>

			<button class="btn pull-right">Submit</button></div>
			</form>
		      </div>
		</div> 
	</div>
</div>
  </section>
  
  @if(!(Auth::check()))
  <section id="intro">
			<div class="container">
 				<div class="col-md-8">
  				
						<h2>iRate Politics is a social network that connects people with friends, politicians, and celebrities. A fun, influential - not to mention addicting and satisfying - way to be active in your government and really make a difference.</h2>
 				</div>
				
 				<div class="col-md-4">
 				  <p><a href="{{URL::ROUTE('create')}}" class="btn btn-lg" id="create-profile">Create Your Profile</a></p>
 				</div>
				

			</div>
  </section>
  @endif
  <section id="latest">
    <div class="container">
      <h2 class="center-title"><span>The Latest</span></h2>
      
      <div class="col-sm-4">
        <div class="box-item">
	<?php $comment = Comment::find($comments[0]['id']);?>
            <div class="politician" title="{{$comment->politician->full_name}}" style="background-image: url('{{$comment->politician->pic_url}}');">
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}" class="politician-inner" style="background-image: url('{{$comment->politician->bw_pic_url}}');">
                <span class="sprite 
		@if($comment->politician->party=='Democrat') 
			dem	
		 
		@elseif ($comment->politician->party=='Republican') rep
		@endif"></span>
              </a>
            </div>
            <h3><a href="{{URL::route('profile-politician',$comment->politician->full_name)}}">{{$comment->politician->full_name}}</a></h3>
            
            <div class="comment">
              <div class="commenter"><a href="{{URL::route('profile-user',$comment->user->username)}}">{{$comment->user->username}}</a> wrote: </div>
              <blockquote>
                "{{$comment->content}}"
              </blockquote>            
            </div>
            
            <div class="voting">
		<?php 
		//if comment is a reply then using it as reference link wont work because replies are hidden on destination page
		//we will send to comment's parent instead 
		if($comment->parent_id ==0)$ref_id= $comment->id;else $ref_id=$comment->parent_id; ?>
              <a class="code" href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-up"><span class="sprite vote-up"></span>{{$comment->rank}}</a>
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-down"><span class="sprite vote-down"></span></a>

              <a class="replies"  href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" >{{$comment->replies()->count()}} replies</a>            
            </div>
            
            
        </div>
        
        <div class="box-item">
           <?php $comment = Comment::find($comments[1]['id']);?>
            <div class="politician" title="{{$comment->politician->full_name}}" style="background-image: url('{{$comment->politician->pic_url}}');">
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}" class="politician-inner" style="background-image: url('{{$comment->politician->bw_pic_url}}');">
                <span class="sprite 
		@if($comment->politician->party=='Democrat') 
			dem	
		 
		@elseif ($comment->politician->party=='Republican') rep
		@endif"></span>
              </a>
            </div>
            <h3><a href="{{URL::route('profile-politician',$comment->politician->full_name)}}">{{$comment->politician->full_name}}</a></h3>
            
            <div class="comment">
              <div class="commenter"><a href="{{URL::route('profile-user',$comment->user->username)}}">{{$comment->user->username}}</a> wrote: </div>
              <blockquote>
                "{{$comment->content}}"
              </blockquote>            
            </div>
            
            <div class="voting">
		<?php 
		//if comment is a reply then using it as reference link wont work because replies are hidden on destination page
		//we will send to comment's parent instead 
		if($comment->parent_id ==0)$ref_id= $comment->id;else $ref_id=$comment->parent_id; ?>
              <a class="code" href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-up"><span class="sprite vote-up"></span>{{$comment->rank}}</a>
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-down"><span class="sprite vote-down"></span></a>

              <a class="replies"  href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" >{{$comment->replies()->count()}} replies</a>            
            </div>
            
            
        </div>    
      </div>
      
      
      <div class="col-sm-4">
      <?php
	$error = false;
	do{
	try{
		$politician =  Politician::find($most_popular_politicians[rand(0,3)]->politician_id);
		$topIssuesList = $politician->topIssues();
		$issue = Issue::find($topIssuesList[rand(0,4)]->issue_id);
       		$topArticle= $issue->googleNews($politician->full_name)[0];
		} catch (Exception $e) {  $error = true;}
	}while($error);
	?>
        <div class="box-item">
	@if(isset($topArticle->image->url))
            <div class="article" title="" style="background-image: url('{{$topArticle->image->url}}');">
              <a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}{{'&pic='.$topArticle->image->url}}{{'&summary='.$topArticle->content}}{{'&title='.$topArticle->title}}"  class="article-inner">
                <span class="sprite news">NEWS</span>
              </a>
            </div>
	@endif
            <h3><a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}@if(isset($topArticle->image->url)){{'&pic='.$topArticle->image->url}}@endif{{'&title='.$topArticle->title}}{{'&summary='.$topArticle->content}}">{{$topArticle->title}}</a></h3><br>
            
            <div class="excerpt">
              <p>{{$topArticle->content}}</p>
            </div>
            
            <div class="tags">
              <a href="{{URL::route('profile-politician',$politician->full_name)}}">{{$politician->full_name}}</a>, <a href="{{URL::route('news',$issue->issue_name)}}">{{$issue->issue_name}}</a>
            </div>
        </div>
        
        <div class="box-item">
            <?php $comment = Comment::find($comments[2]['id']);?>
            <div class="politician" title="{{$comment->politician->full_name}}" style="background-image: url('{{$comment->politician->pic_url}}');">
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}" class="politician-inner" style="background-image: url('{{$comment->politician->bw_pic_url}}');">
                <span class="sprite 
		@if($comment->politician->party=='Democrat') 
			dem	
		 
		@elseif ($comment->politician->party=='Republican') rep
		@endif"></span>
              </a>
            </div>
            <h3><a href="{{URL::route('profile-politician',$comment->politician->full_name)}}">{{$comment->politician->full_name}}</a></h3>
            
            <div class="comment">
              <div class="commenter"><a href="{{URL::route('profile-user',$comment->user->username)}}">{{$comment->user->username}}</a> wrote: </div>
              <blockquote>
                "{{$comment->content}}"
              </blockquote>            
            </div>
            
            <div class="voting">
		<?php 
		//if comment is a reply then using it as reference link wont work because replies are hidden on destination page
		//we will send to comment's parent instead 
		if($comment->parent_id ==0)$ref_id= $comment->id;else $ref_id=$comment->parent_id; ?>
              <a class="code" href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-up"><span class="sprite vote-up"></span>{{$comment->rank}}</a>
              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="vote-down"><span class="sprite vote-down"></span></a>

              <a class="replies"  href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" >{{$comment->replies()->count()}} replies</a>            
            </div>
            
            
        </div>
        
      </div>
      
      <div class="col-sm-4">
      <?php
	$first_url = $topArticle->unescapedUrl;
	$error = false;
	do{
	try{
		$politician =  Politician::find($most_popular_politicians[rand(0,3)]->politician_id);
		$topIssuesList = $politician->topIssues();
		$issue = Issue::find($topIssuesList[rand(0,4)]->issue_id);
       		$topArticle= $issue->googleNews($politician->full_name)[0];
		} catch (Exception $e) {  $error = true;}
	}while(($error)||($first_url==$topArticle->unescapedUrl));
	?>
        <div class="box-item">
	@if(isset($topArticle->image->url))
            <div class="article" title="" style="background-image: url('{{$topArticle->image->url}}');">
              <a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}{{'&pic='.$topArticle->image->url}}{{'&summary='.$topArticle->content}}{{'&title='.$topArticle->title}}"  class="article-inner">
                <span class="sprite news">NEWS</span>
              </a>
            </div>
	@endif
            <h3><a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}@if(isset($topArticle->image->url)){{'&pic='.$topArticle->image->url}}@endif{{'&summary='.$topArticle->content}}{{'&title='.$topArticle->title}}">{{$topArticle->title}}</a></h3><br>
            
            <div class="excerpt">
              <p>{{$topArticle->content}}</p>
            </div>
            
            <div class="tags">
              <a href="{{URL::route('profile-politician',$politician->full_name)}}">{{$politician->full_name}}</a>, <a href="{{URL::route('news',$issue->issue_name)}}">{{$issue->issue_name}}</a>
            </div>
        </div>
        
        <div class="box-item">
	<?php
	$second_url = $topArticle->unescapedUrl;
	$error = false;
	do{
		try{
			$politician =  Politician::find($most_popular_politicians[rand(0,3)]->politician_id);
			$topIssuesList = $politician->topIssues();
			$issue = Issue::find($topIssuesList[rand(0,4)]->issue_id);
	       		$topArticle= $issue->googleNews($politician->full_name)[0];
		} catch (Exception $e) {  $error = true;}
	}while(($error)||($first_url==$topArticle->unescapedUrl)||($second_url==$topArticle->unescapedUrl))

	?>
        @if(isset($topArticle->image->url))
            <div class="article" title="" style="background-image: url('{{$topArticle->image->url}}');">
              <a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}{{'&pic='.$topArticle->image->url}}{{'&summary='.$topArticle->content}}{{'&title='.$topArticle->title}}"  class="article-inner">
                <span class="sprite news">NEWS</span>
              </a>
            </div>
	@endif
            <h3><a href="{{URL::route('article')}}{{'?url='.$topArticle->unescapedUrl}}@if(isset($topArticle->image->url)){{'&pic='.$topArticle->image->url}}@endif{{'&summary='.$topArticle->content}}{{'&title='.$topArticle->title}}">{{$topArticle->title}}</a></h3><br>
            
           <div class="excerpt">
              <p>{{$topArticle->content}}</p>
            </div>
            
            
            <div class="tags">
              <a href="{{URL::route('profile-politician',$politician->full_name)}}">{{$politician->full_name}}</a>, <a href="{{URL::route('news',$issue->issue_name)}}">{{$issue->issue_name}}</a>
            </div>
        </div>
        
      </div>
      
    </div>
  </section>
  
    


	</section><!-- #pageContainer -->

@include('footer',array('chart'=>'false','issue_tag_cloud'=>$issue_tag_cloud))
