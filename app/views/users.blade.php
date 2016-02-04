@include('header')
<section id="pageContainer" class="section">
	<div class="container">
		
		<section id="results"  style="margin-top: -20px;">
		{{ $users->links() }}
		@foreach ($users as $user) 
			<div class="row">
        	        	<div class="col-sm-3">
          				<div class="politician" title="{{$user->username}}" style="background-image: url('@if((isset($user->pic_url))&&($user->pic_url !='')){{$user->pic_url}}@else {{'/assets/images/avatars/default/default-avatar.jpg'}}@endif');">
						<a href="{{URL::route('profile-user',$user->username)}}">
            <span class="user-inner" >
		
		@if($user->party=='Democrat') 
		  <span class="sprite dem-lg"> </span>	
		@endif
		@if ($user->party=='Republican') 
		  <span class="sprite rep-lg"> </span>
		@endif
		
              
            </span>
      </a>    </div>
        </div>
        
        <div class="col-sm-3">
          <h1><a href="{{URL::route('profile-user',$user->username)}}">{{$user->username}}</a></h1>
	 @if(Auth::user()->isAdmin()) 
	  	<h2><a href="{{URL::route('edit-user', $user->username)}}" style="text-decoration:underline;">EDIT PROFILE</a></h2>
	  @endif
          
          
          
         
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
	</form>
        </div>
        
        <div class="col-sm-6">
        <div id="{{$user->id}}" class="users-chart"></div>
        </div>
        
      </div>
    
@endforeach
{{ $users->links() }}
</div>

 
</section>   
  
     
  


	</section><!-- #pageContainer -->

@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
