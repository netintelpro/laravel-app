@include('header')
  <section id="pageContainer" class="section">
  <section id="intro">
    <div class="container edit-user">
      <div class="row">
        
        <div class="col-sm-3">
	<h3>Upload Photo</h3>
          <div id="imagePreview" class="politician" title="" style="background-image: url('');"></div>
           <form action="" method="post" class="form" id="edit-user" enctype="multipart/form-data" role="form">

	  <input type="file" name="photo" id="photo" class="img">
        </div>
        
        
        
        <div class="col-sm-6">
						<div class="row">  
                 					<input class="form-control" id="username" name="username" placeholder="User Name" type="text" required |="">
						
							<input class="form-control" name="password" placeholder="New Password" type="password" required />
					                
							<input class="form-control" name="password_again" placeholder="Re-enter Password" type="password" required />

						</div>

                				<div class="row">
   
                 				<div class="col-xs-6 col-md-6">
			                        	<input class="form-control" value="" id="first_name" name="first_name" placeholder="First Name" type="text"  |="" autofocus="">
                    				</div>
						<div class="col-xs-6 col-md-6">
							<input class="form-control" value="" id="last_name" name="last_name" placeholder="Last Name" type="text" |="">
					</div>

						<div class="col-xs-6 col-md-6">
							<input class="form-control" value="" id="email" name="email" placeholder="Email" type="text" required |="">
					</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
				@if(Auth::user()->isAdmin())
					<select class="form-control" name="role" id="role">
				
					<?php $options = array('regular','admin');?>
					@foreach($options as $option)
					 <option>{{$option}}</option>
					@endforeach
		       			    
		        		</select>
				@endif
                    			</div>
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="" id="birth_day" name="birth_day" placeholder="Birth Day" type="text" |="">
						<input class="form-control" value="" id="birth_month" name="birth_month" placeholder="Birth Month" type="text" |="">
						<input class="form-control" value="" id="birth_year" name="birth_year" placeholder="Birth Year" type="text" |="">                    			
					</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="" id="city" name="city" placeholder="City" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
						<select class="form-control" name="state" id="state">
							@foreach(State::all() as $state)
						 		<option>{{$state->title}}</option>
							@endforeach
                        			</select>
                    			</div>
			
                		
					<div class="col-xs-6 col-md-6">
					<select class="form-control" name="party" id="party">
							<?php $options = array('Party','Democrat','Republican','Independant','Liberatarian','Green');?>
							@foreach($options as $option)
								 <option>{{$option}}</option>
							@endforeach
	               			    
		                	</select>
					</div>
				</div>
	

               			
                
                		<label class="radio-inline">
                			<input type="radio" name="sex" id="sex" value="male">
                    			Male
                		</label>
				<label class="radio-inline">
				    <input type="radio" name="sex" id="sex" value="female">
				    Female
				</label>
                
		<textarea type="text"  placeholder="Biography..." class="form-control" id="bio" name="bio" style="height: 50px;"></textarea>
		
                                
                
                <button class="btn btn-lg btn-block light" id="edit-user-button" type="submit">Submit</button><br>

                    
             </form>
        </div>
        
      </div>
    </div>
  </section>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
