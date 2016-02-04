        <div class="col-sm-6" id="activity">
             <h2>Recent Activity</h2>
                       
            @if($comments != null)
               <ul class="list-group">
		@foreach($comments as $comment)
                  <li class="list-group-item">
                      <div class="row">
                          <div class="col-sm-3">                                          
                            <div class="politician" title="{{$comment->politician->full_name}}" style="background-image: url('{{$comment->politician->pic_url}}');">
                              <a href="{{URL::route('profile-politician',$comment->politician->full_name)}}" class="politician-inner" style="background-image: url('{{$comment->politician->bw_pic_url}}');">
                                <span class="sprite 
				@if($comment->politician->party=='Democrat') 
					dem	
		 
				@elseif ($comment->politician->party=='Republican') rep
				@endif">
				</span>
                              </a>
                            </div>
                          </div>
                              
                          <div class="col-sm-9">
                              <h3><a href="{{URL::route('profile-politician',$comment->politician->full_name)}}">{{$comment->politician->full_name}}</a></h3>
                              <div class="mic-info">
                                  <a href="{{URL::route('profile-user',$comment->user->username)}}">{{$comment->user->username}}</a> <span class="date">on {{date( 'D M d, Y',strtotime( $comment->created_at))}}</span>
                              </div>
                              <blockquote  class="comment-text">
				{{$comment->content;}}
                              </blockquote>
                             
                          </div>
                      </div>
                      <div class="row">
                          <div class="comment-meta">
                            <div class="col-sm-3">
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
                            <div class="col-sm-7">
                              <div class="topics">
                                <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Healthcare</a> 
                                <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Economy</a>
                                <a href="" class="thumbs-down"><span class="sprite thumbs-down"></span> Immigration</a>
                              </div>
                            </div>
                            <div class="col-sm-2">
			    <?php 
				$reply_count = $comment->replies()->count();
				//if comment is a reply then using it as reference link wont work because replies are hidden on destination page
				//we will send to comment's parent instead 
				if($comment->parent_id ==0)
					$ref_id= $comment->id;
				else $ref_id=$comment->parent_id; 

			    ?>
                            <a  href="{{URL::route('profile-politician',$comment->politician->full_name)}}{{'/#'.$comment->user->username.'-'.$ref_id}}" class="replies pull-right" id="{{$comment->id}}-{{$comment->politician->id}}">{{$reply_count}}@if($reply_count==1){{' reply'}}@else{{' replies'}}@endif</a> 
                            </div>
                          </div>
                      </div>
                  </li>
                @endforeach
                 
              </ul>
	      @endif
           
      
        
          
    
        </div>
