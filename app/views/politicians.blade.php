@include('header')
<section id="pageContainer" class="section politicians">
	<div class="container">
		
		<section id="results"  style="margin-top: -20px;">
		{{ $politicians->links() }}
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
	  @if(Auth::check())
		  @if(Auth::user()->isAdmin()) 
		  	<h2><a href="{{URL::route('edit-politician', $politician->full_name)}}" style="text-decoration:underline;">EDIT PROFILE</a></h2>
		  @endif
	  @endif
          <h2>{{$politician->office}}</h2>
          <h3>{{$politician->district}}</h3>
          
          <!-- http://plugins.krajee.com/star-rating/demo -->
          <form class="ratings"  role="form">          
            
            <input id="input-{{$politician->id}}" class="rating" data-min="0"  data-max="5"  data-stars="5"    value="{{5* ( $politician->rank/DB::table('politicians')->max('rank'))}}"  data-readonly="true" data-show-clear="false" data-show-caption="false" type="number">    
          </form>
          @if(Auth::check())
		  <button class="follow btn btn-lg" id="{{$politician->id}}">
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
	</form>
        </div>
        
        <div class="col-sm-6">
          <div class="politicians-chart" id="{{$politician->id}}"></div>
		
        </div>
        
      </div>
    
@endforeach
{{ $politicians->links() }}
</div>

 
</section>   
  
     
  


	</section><!-- #pageContainer -->

@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
