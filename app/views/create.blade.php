@include('header')
	<section id="pageContainer" class="section">
		<section id="results">
			<div class="container">
				<h1 style="margin-up:-20px;">Sign Up</h1>
			        <div class="row">
            				<div style="margin-up:-20px;" class="col-md-5">
						<h3>Be active in your government!</h3>
						<p>[facebook sign up]</p>
						<h2 class="center-title"><span>OR</span></h2>
						<form action="{{URL::route('create-post')}}" method="post" class="form" enctype="multipart/form-data" role="form">
							<div class="row">
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="firstname" placeholder="First Name" type="text"
								    required 
								{{(Input::old('firstname')) ? 'value="'.e(Input::old('firstname')).'"':'|'}}			
								autofocus />
							    </div>
							    <div class="col-xs-6 col-md-6">
								<input class="form-control" name="lastname" placeholder="Last Name" type="text" required 
								{{(Input::old('lastname')) ? 'value="'.e(Input::old('lastname')).'"':'|'}}/>
							    </div>
							</div>
							<input class="form-control" name="username" placeholder="Your Username" type="text" 
							required {{(Input::old('username')) ? 'value="'.e(Input::old('username')).'"':'|'}}/>
							@if($errors->has('username'))
								{{$errors->first('username')}}
							@endif
							<input class="form-control" name="email" placeholder="Your Email" 
							  type="email" {{(Input::old('email')) ? 'value="'.e(Input::old('email')).'"':'|'}} />
							@if($errors->has('email'))
								{{$errors->first('email')}}
							@endif
							<input class="form-control" name="password" placeholder="New Password" type="password" />
							@if($errors->has('password'))
								{{$errors->first('password')}}
							@endif                
							<input class="form-control" name="password_again" placeholder="Re-enter Password" type="password" />
							@if($errors->has('password_again'))
								{{$errors->first('password_again')}}
							@endif
							<select class="form-control" name="party">
							    <option value="party">Party Affiliation (optional)</option>
							    <option>Democrat</option>
							    <option>Republican</option>
							    <option>Independant</option>
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
							<input type="file" name="photo">
							<div class="topics">
								<h3>Issues I Care About</h3>
							   		@foreach ($issues as $issue)
									<span class="button-checkbox">
									      <button type="button" class="btn" data-color="primary">{{ ucwords($issue->issue_name) }}</button>
									      <input type="checkbox" class="hidden" name ="{{ $issue->id }}" value="{{ $issue->id }}"/>
									</span>
									@endforeach
							</div>
							<p>[captcha goes here]</p>
							<p>By creating an account you agree to iRate Politics Terms of Service and Privacy Policy.</p>
							<button class="btn btn-lg btn-block light" type="submit">Sign up</button>
							<p class="already pull-right">Already on iRate Politics? <a href="{{URL::route('login')}}">Log in</a></p>
					 		{{Form::token()}}
						</form>
            				</div>
            			        <div class="col-md-6 col-md-offset-1">
              					<img src="/assets/images/capitol.jpg" alt="Our Capitol"/>
            				</div>
        			</div>
			</div>			
  		</section>
	</section><!-- #pageContainer -->
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
