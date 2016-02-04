@include('header')
<section id="pageContainer" class="section">
	<section id="intro">
   		<div class="container">
      			<div class="row">
				<div class="col-sm-2">
				    <img src="{{$user->pic_url}}" class="img-circle img-responsive" alt="" />
				</div>
				<div class="col-sm-4">
					<h1>{{$user->username}}</h1>
					<h2> 
						@if($user->party=="Democrat"){{'<span class="sprite dem"></span>'}}@endif 
						@if($user->party=="Republican"){{'<span class="sprite rep"></span>'}}@endif {{$user->party}}
					</h2>
					<h3>{{$user->city}}, {{$user->state}}</h3>
					<p>Bio: {{$user->bio}}</p>
					@if($user->id != Auth::user()->id )
						   
					<button class="btn btn-lg user-follow" id="{{$user->id}}" >@if(Auth::user()->following_user($user->id))
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
     		</div>
  	</section>

  <section id="details">
    <div class="container">
      <div class="row">
      @include('user-comments')
      @include('user-politicians-followed')
      </div>
    </div>
  </section>
  
  
  
  
   



</section><!-- #pageContainer -->
<script>
jQuery(document).ready(function() 
{
$( "body" ).removeClass( "home-page" ).addClass( "profile-page @if($user->party=='Democrat'){{'democrat'}}@endif
@if($user->party=='Republican'){{'republican'}}@endif" );




});
</script>
@include('footer_user',array('chart'=>'true','issue_tag_cloud'=>'null','democrat_chart_data'=>$democrat_chart_data,'republican_chart_data'=>$republican_chart_data))
