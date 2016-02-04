@include('header')

	<section id="pageContainer" class="section">
		<section id="results">
			<div class="container">
				<h1 >Contact Us</h1>
			        <div class="row">
            				<div class="col-md-5">
						<h3>We want to hear from you!</h3>


						<form action="{{URL::route('contact')}}" method="post" class="form" enctype="multipart/form-data" role="form">
							@if($errors->has('name'))
								<label style="color:red;">{{$errors->first('name')}}</label>
							@endif

							<input class="form-control" name="name" placeholder="Your Name" type="text" 
							required {{(Input::old('name')) ? 'value=" "':'|'}}/>
							
							@if($errors->has('email'))
								<label style="color:red;">{{$errors->first('email')}}</label>
							@endif
							<input class="form-control" name="email" placeholder="Your Email" 
							  type="email" {{(Input::old('email')) ? 'value="'.e(Input::old('email')).'"':'|'}} />
							@if($errors->has('password'))
								<label style="color:red;">{{$errors->first('subject')}}</label>
							@endif 
							<input class="form-control" name="subject" placeholder="Subject" type="text" />
							@if($errors->has('subject'))
								<label style="color:red;">{{$errors->first('message')}}</label>
							@endif               
							<textarea name="message" cols="40" rows="10" class="form-control" placeholder="Your Message"></textarea>
							
							    
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

							<button class="btn btn-lg btn-block light" type="submit">Submit</button>

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
