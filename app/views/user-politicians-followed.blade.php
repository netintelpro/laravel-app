<div class="col-sm-6" id="following">
          <h2>Following</h2>
	  @if($politicians != null)
		 @foreach ($politicians as $politician) 

		 
		  <div class="row">
		      <div class="col-sm-4">
		        <div class="politician" title="{{$politician->full_name}}" style="background-image: url('{{$politician->pic_url}}');">
		          <a href="{{URL::route('profile-politician',$politician->full_name)}}" class="politician-inner"  
				style="background-image: url('{{$politician->bw_pic_url}}');">
		            <span class="sprite 

				@if($politician->party=='Democrat')
					{{'dem-lg'}} 
				@elseif($politician->party=='Republican')
					{{'rep-lg'}}
				@endif "></span>
		            <span class="sprite @if(Politician::find($politician->id)->ratings->sum('value') > 0)trend-up-stat 
			@else trend-down-stat
			@endif">{{Politician::find($politician->id)->ratings->sum('value')}}</span>
			   
		            <span href="{{URL::route('profile-politician',$politician->full_name)}}" class="btn follow">

				@if(Politician::find($politician->id)->users()->where('users.id', '=', Auth::user()->id)->count())
		            		{{'Un-Follow'}}
				@else
					{{'Follow'}}
				@endif
			   </span>
		          </a>

		        </div>

		        <form class="ratings" style="padding: 10px 0px 4px 0px">          
            			<input id="input-{{$politician->id}}" class="rating" data-min="0"  data-max="5"  data-stars="5"    
				value="{{5* ( $politician->rank/DB::table('politicians')->max('rank'))}}"  data-readonly="true" 
				data-show-clear="false" data-show-caption="false" type="number">    
		        </form>                
		      </div>
		      
		      <div class="col-sm-8">               
		        
		        <div id="{{$politician->id}}" class="politicians-chart"></div>
		        
		      </div>              
		  </div>
		  
		 @endforeach 
         
          
         @endif            
        </div>
