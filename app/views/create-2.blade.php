@include('header')
@if(isset($rant_data))
		<h1>Rant</h1>
	<input type="hidden" value={{$rant_data['rant']}} name="rant" />
	<input type="hidden" value={{$rant_data['auto-politician']}} name="auto-politician" />
@endif
	<section id="pageContainer" class="section">
		<section id="results">
			<div class="container">
				<h1 style="margin-up:-20px;">Sign Up: Step 2</h1>
			        <div class="row">
            				<div style="margin-up:-20px;" class="col-md-5">
						
						<form action="{{URL::route('create-post-2')}}" method="post" class="form" enctype="multipart/form-data" role="form">
							@if(isset($rant_data))

								<input type="hidden" value={{$rant_data['rant']}} name="rant" />
								<input type="hidden" value={{$rant_data['auto-politician']}} name="auto-politician" />
							@endif	
                                                       <div class="row">
								<div class="col-xs-6 col-md-6">
									<input class="form-control" name="username" placeholder="Your Username" type="text" 
									required value="{{Auth::user()->username}}"/>
								</div>
							</div>

							<div class="row">
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="firstname" placeholder="First Name" type="text"
								 @if(isset(Auth::user()->first_name)))
									value="{{Auth::user()->first_name}}"
								 @else    
									{{(Input::old('firstname')) ? 'value="'.e(Input::old('firstname')).'"':'|'}}			
								 @endif								
								autofocus />
							    </div>
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="lastname" placeholder="Last Name" type="text"  
								
								@if(isset(Auth::user()->last_name)))
									value="{{Auth::user()->last_name}}"
								 @else 
									{{(Input::old('lastname')) ? 'value="'.e(Input::old('lastname')).'"':'|'}}/>
							    	@endif
							    </div>
							</div>
							
							<select class="form-control" name="party">
							    <option value="party">Party Affiliation (optional)</option>
							    <option>Democrat</option>
							    <option>Republican</option>
							    <option>Independent</option>
							    <option>Unaffiliated</option>
							</select>
				
							<label for="">
							    Birth Date</label>
							<div class="row">
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_month">
								    <option value="00">Month</option>
								     <option value="01">January</option>
								    <option value="02">February</option>
								    <option value="03">March</option>
								    <option value="04">April</option>
								    <option value="05">May</option>
								    <option value="06">June</option>
								    <option value="07">July</option>
								    <option value="08">August</option>
								    <option value="09">September</option>
								    <option value="10">October</option>
								    <option value="11">November</option>
								    <option value="12">December</option>
								</select>
						
							    </div>
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_day">
								    <option value="Day">Day</option>
								    @for($x=0;$x<=31;$x++)
									<option value="{{$x}}">{{$x}}</option>
								    @endfor
								</select>
							    </div>
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_year">
								    	<option value="Year">Year</option>
								     	<?php 
										$starting_year  = date('Y', strtotime('-10 year'));
									        $ending_year    = date('Y', strtotime('-120 year'));?>
										 @for($starting_year; $starting_year >= $ending_year; $starting_year--) 
										 	<option value="{{$starting_year}}">{{$starting_year}}</option>
										 @endfor             	
								</select>
							    </div>
							</div>
							<label class="radio-inline">
							    <input type="radio" name="sex" id="sex" value="male" />
							    Male
							</label>
							<label class="radio-inline">
							    <input type="radio" name="sex" id="sex" value="female" />
							    Female
							</label>

							<textarea type="text"placeholder="More about me..." class="form-control" id="bio" name="bio"  style="height: 50px;"></textarea>
							<h3>Upload a Photo</h3>
							@if($errors->has('photo'))
								<label style="color:red;">{{$errors->first('photo')}}</label>
							@endif 
							<input type="file" name="photo" id="photo">
							<div class="topics">
								<h3>Issues I Care About</h3>
							   		@foreach ($issues as $issue)
									<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">{{ ucwords($issue->issue_name) }}</button>
									      <input type="checkbox" class="hidden" name ="{{ $issue->id }}" value="{{ $issue->id }}"/>
									</span>
									@endforeach
							</div>
							<button class="btn btn-lg btn-block light" type="submit">Finish</button>
						</form>
            				</div></div>
            			        <div class="col-md-6 col-md-offset-1">
              					<img src="/assets/images/capitol.jpg" alt="Our Capitol"/>
            				</div>
        			</div>
			</div>			
  		</section>
	</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
