@include('header')
<section id="pageContainer" class="section">
	<form action="{{URL::route('edit-myprofile')}}" method="post" class="form" enctype="multipart/form-data" role="form">
	<section id="intro">
	<div class="container">
	<h1>My Profile</h1>
		<div class="row">
			<div id="col-left" class="col-md-5">
			<h3>Upload a Photo</h3>
			<div id="imagePreview" class="politician" title="" style="background-image: url('{{Auth::user()->pic_url}}');"></div>
				   <form action="" method="post" class="form" id="edit-user" enctype="multipart/form-data" role="form">
				   <input type="hidden"  id="image_uploaded" name= "image_uploaded" value="false">
				  <input type="file" name="photo" id="photo" class="img">


			<h3 style="padding-top:10px;">My Notifications</h3>
				<div class="row" style="padding-top:10px;" >
					<label class="radio-inline">
						<input  type="checkbox" name="response_notice" id="response_notice" value=1 @if(Auth::user()->response_notice) {{'checked'}} @endif  >
						Receive email notice of responses to my comments.<br>
					</label>
				</div>
				<div class="row" style="padding-top:10px;">
					<label class="radio-inline">
						<input  type="checkbox" name="rank_notice" id="rank_notice" value="1" @if(Auth::user()->rank_notice) {{'checked'}} @endif >
						Receive email notice of up/down votes on my comments.<br>
					</label>
				</div>
				<div class="row" style="padding-top:10px;" >
					<label class="radio-inline">
						<input  type="checkbox" name="thread_notice" id="thread_notice" value="1" @if(Auth::user()->thread_notice) {{'checked'}} @endif >
						Receive email notice of new comments on thread<br>
					</label>
				</div>
		</div>


			
		        <div id="col-right" class="col-md-6 col-md-offset-1">

							<div class="row">
							    <div class="col-xs-6 col-md-6">
								<label>Username</label>
		
		
								<input class="form-control" name="username" placeholder="User Name" type="text"
								    required 
								value="{{Auth::user()->username}}"			
								autofocus />
							    </div>
							    <div class="col-xs-6 col-md-6">
								<label>Email</label>
								<input class="form-control" name="email" placeholder="Email Name" type="text" required 
								value="{{Auth::user()->email}}"/>
							    </div>
							</div>	
							<div class="row">
								<div class="col-xs-6 col-md-6">
									<label>Password</label>
									<input class="form-control" name="password" type="password" />
									@if($errors->has('password'))
										{{$errors->first('password')}}
									@endif 
							    	</div>
								    <div class="col-xs-6 col-md-6">
									<label>Password Again</label>
									<input class="form-control" name="password_again"  type="password"/>
								    	@if($errors->has('password_again'))
										{{$errors->first('password_again')}}
									@endif
								    </div>
							</div>							

							<div class="row">
							    <div class="col-xs-6 col-md-6">

								<label>First Name</label>
								<input class="form-control" name="firstname" placeholder="First Name" type="text"
								    required 
								value="{{Auth::user()->first_name}}"			
								autofocus />
							    </div>
							    <div class="col-xs-6 col-md-6">
								<label>Last Name</label>
								<input class="form-control" name="lastname" placeholder="Last Name" type="text" required 
								value="{{Auth::user()->last_name}}"/>
							    </div>
							</div>

							<div class="row">
							    <div class="col-xs-6 col-md-6">
							<label>City</label>
                        			<input class="form-control" value="{{Auth::user()->city}}" id="city" name="city" placeholder="City" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
						<label>State</label>
						<select class="form-control" name="state" id="state">
							@foreach(State::all() as $state)
						 		<option  @if(Auth::user()->state == $state->title) selected @endif>{{$state->title}}</option>
							@endforeach
                        			</select>
                    			</div>
							</div>
							<label>Party</label>
							<select class="form-control" name="party">
						  		<option @if(Auth::user()->party=='Democrat') {{'selected'}}  @endif >Democrat</option>
				    				<option @if(Auth::user()->party=='Republican') {{'selected'}} @endif >Republican</option>
				    				<option @if(Auth::user()->party=='Independent') {{'selected'}}@endif >Independent</option>
								<option @if(Auth::user()->party=='Unaffiliated'){{'selected'}}@endif >Unaffiliated</option>
							</select>
						
							<label for="">
							    Birth Date</label>
							<div class="row">
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_day">
								    <option @if(Auth::user()->birth_day == null)  {{'selected'}}@endif value="Day">Day</option>
								    @for($x=0;$x<=31;$x++)
									<option @if(Auth::user()->birth_day== $x) {{'selected'}}@endif  value="{{$x}}">{{$x}}</option>
								    @endfor
								</select>
							    </div>
							    <div class="col-xs-4 col-md-4">
								<select class="form-control" name="birth_month">
								    @for($x=1;$x<=12;$x++)
									<option @if(Auth::user()->birth_month== $x) {{'selected'}}@endif  value="{{$x}}">{{date("F", mktime(0, 0, 0,$x,10))}}</option>
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
										 	<option @if(Auth::user()->birth_year== $starting_year) {{'selected'}}@endif value="{{$starting_year}}">{{$starting_year}}</option>
										 @endfor             	
								</select>
							    </div>
							</div>
							<label>Sex</label>
							<div class="row" style="padding-bottom: 14px;">
								<div class="col-xs-4 col-md-4">
									<label class="radio-inline">
									    <input type="radio" name="sex" id="sex" value="male" @if(Auth::user()->sex=='male') {{'checked'}}@endif />
									    Male
									</label>
									<label class="radio-inline">
									    <input type="radio" name="sex" id="sex" value="female" @if(Auth::user()->sex=='female') {{'checked'}}@endif />
									    Female
									</label>
								</div>
							</div>
							<label>Bio</label>
							<div class="row">
							<textarea type="text"  placeholder="Biography..." class="form-control" id="bio" name="bio" style="height: 100px;">{{Auth::user()->bio}}</textarea>
							   
							</div>
				<button class="btn btn-lg btn-block light" id="edit-myprofile-button" type="submit">Submit</button><br>
	<!--	<a style="float:right;" data-href="delete.php?id=23" data-toggle="modal" data-target="#confirm-delete" href="#">Delete My Account</a>
          -->      {{Form::token()}}
        </form>		


			</div>
		</div>
		<div class="row" style="padding-top:20px">
			<div >	

			<form action="{{URL::route('update-issues-followed')}}" method="post" class="form" enctype="multipart/form-data" role="form">
			<h3>Issues I Care About</h3>
			<a class="anchor" href="#issues" id="issues"></a>
			   		@foreach ($issues as $issue)
					<span class="button-checkbox">
					      <button type="button" class="btn" data-color="primary" 
						@if(in_array($issue->id,$issues_followed)) checked @endif>{{ ucwords($issue->issue_name) }}</button>
					      <input type="checkbox" class="hidden" name ="{{ $issue->id }}" value="{{ $issue->id }}" 
						@if(in_array($issue->id,$issues_followed)) checked @endif/>
					  </span>
					@endforeach
			<div class="col-md-6 col-md-offset-1" style ="float: right;">
				<button class="btn btn-lg btn-block light" id="update-issues-followed-button" type="submit">Submit</button><br>
			</div>
			{{Form::token()}}
			</form>	
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

@include('footer',array('chart'=>'false','issue_tag_cloud'=>null))
