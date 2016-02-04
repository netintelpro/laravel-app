@include('header')
<script type="text/javascript" src="/assets/js/facebook.js"></script>

	<section id="pageContainer" class="section">
		<section id="results">
			<div class="container">
				<h1 >Sign Up</h1>
			        <div class="row">
            				<div class="col-md-5">
						<h3>Be active in your government!</h3>
						@include('fb-login')
						<h2 class="center-title"><span>OR</span></h2>
						<form action="{{URL::route('create-post-1')}}" method="post" class="form" enctype="multipart/form-data" role="form">
							@if(isset($rant_data))
								<input type="hidden" value={{$rant_data['rant']}} name="rant" />
								<input type="hidden" value={{$rant_data['auto-politician']}} name="auto-politician" />
							@endif							


							@if($errors->has('username'))
								<label style="color:red;">{{$errors->first('username')}}</label>
							@endif

							<input class="form-control" name="username" placeholder="Your Username" type="text" 
							required {{(Input::old('username')) ? 'value="'.e(Input::old('username')).'"':'|'}}/>
							
							@if($errors->has('email'))
								<label style="color:red;">{{$errors->first('email')}}</label>
							@endif
							<input class="form-control" name="email" placeholder="Your Email" 
							  type="email" {{(Input::old('email')) ? 'value="'.e(Input::old('email')).'"':'|'}} />
							@if($errors->has('password'))
								<label style="color:red;">{{$errors->first('password')}}</label>
							@endif 
							<input class="form-control" name="password" placeholder="New Password" type="password" />
							@if($errors->has('password_again'))
								<label style="color:red;">{{$errors->first('password_again')}}</label>
							@endif               
							<input class="form-control" name="password_again" placeholder="Re-enter Password" type="password" />
							
							    
							@if($errors->has('recaptcha_response_field'))
								<label style="color:red;">{{$errors->first('recaptcha_response_field')}}</label>
							@endif
							<p>
							
								<?php
								  require_once('/var/www/html/laravel/app/library/recaptchalib.php');
								  $publickey = "6LdaP_oSAAAAAIPnEWVCH4eNrI-o917hgLLjLNI_ "; // you got this from the signup page
								  echo recaptcha_get_html($publickey);
								?>

							</p>
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
