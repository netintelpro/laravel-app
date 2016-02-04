@include('header')
@if($fb_sign_out)


<input id="fb_stat" value="logout" type="hidden">
@endif
<script type="text/javascript" src="/assets/js/facebook.js"></script>

<section id="pageContainer" class="section">


   
  
  <section id="results">
			<div class="container">
			  
        <div class="row">
            
            <div class="col-md-6">
              <img src="assets/images/capitol2.jpg" alt="Our Capitol"/>
            </div>
            
            <div class="col-md-5 ">

                <h1 style="margin-top: 30px;">Log In</h1>
                <h3>Welcome back fellow American!</h3>
                
		@include('fb-login')
                
                <h2 class="center-title"><span>OR</span></h2>
                
                <form action="{{URL::route('login-post')}}" method="post" class="form" role="form">
		@if($errors->has('email'))
			{{$errors->first('email')}}
		
		@endif 
                <input class="form-control" name="email" placeholder="Your Email" type="email" {{(Input::old('email')) ? 'value="'.e(Input::old('email')).'"':'|'}} />
		@if($errors->has('password'))
			{{$errors->first('password')}}
		
		@endif              
		<input class="form-control" name="password" placeholder="New Password" type="password" />
                
            

                <button class="btn btn-lg btn-block light" type="submit">
                    Log in</button>

                    
                    <p class="already pull-left"><a href="{{URL::ROUTE('create')}}">Don't have an account?</a></p>
                    <p class="already pull-right"><a href="#">Forgot password?</a></p>
		                {{Form::token()}}
                </form>
            </div>
            
        </div>

			</div>			
  </section>
   
  


	</section><!-- #pageContainer -->

@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))

