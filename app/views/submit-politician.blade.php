@include('header')
  <section id="pageContainer" class="section">
  <section id="intro">
    <div class="container edit-politicians">
      <div class="row">
	<div class="col-sm-3">
		<h3>Upload Politician Photo</h3>
		<div id="imagePreview"  title="" style="background-image: url('');"></div>
        	<form action="" method="post"  id="create-politician" enctype="multipart/form-data">
        		<input type="hidden"  id="image_uploaded" name= "image_uploaded" value="false" role="form">
			<input type="file" name="photo" id="photo" class="img">
 	</div>
        
        <div class="col-sm-3"></div>        
        <div class="col-sm-6">
			<div class="row">
   
                 				
				@if($errors->has('full_name'))
					<label style="color:red;">{{$errors->first('full_name')}}</label>
				@endif
                    				
				<input class="form-control" id="full_name" name="full_name" placeholder="Full Name" type="text"  |="">
						
			
                		</div>
                		<div class="row">
   
                 				<div class="col-xs-6 col-md-6">
							@if($errors->has('first_name'))
								<label style="color:red;">{{$errors->first('first_name')}}</label>
							@endif
			                        	<input class="form-control" id="first_name" name="first_name" placeholder="First Name" type="text" |="" autofocus="">
                    				</div>
						<div class="col-xs-6 col-md-6">
							@if($errors->has('last_name'))
								<label style="color:red;">{{$errors->first('last_name')}}</label>
							@endif
							<input class="form-control" id="last_name" name="last_name" placeholder="Last Name" type="text"  |="">
						</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
						@if($errors->has('office'))
							<label style="color:red;">{{$errors->first('office')}}</label>
						@endif
                        			<input class="form-control" id="office" name="office" placeholder="Office" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">

						@if($errors->has('district'))
							<label style="color:red;">{{$errors->first('district')}}</label>
						@endif
                        			<input class="form-control" id="district" name="district" placeholder="District" type="text" |="">
                    			</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
						@if($errors->has('city'))
							<label style="color:red;">{{$errors->first('city')}}</label>
						@endif
                        			<input class="form-control" id="city" name="city" placeholder="City" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
						@if($errors->has('state'))
							<label style="color:red;">{{$errors->first('state')}}</label>
						@endif
                        			<input class="form-control" id="state" name="state" placeholder="State" type="text" |="">
                    			</div>
			
                		</div>
	
				<div class="row">
					@if($errors->has('party'))
							<label style="color:red;">{{$errors->first('party')}}</label>
						@endif
		       			<select class="form-control" name="party" id="party">
		       			     <option value="party">Party Affiliation</option>
		       			     <option>Democrat</option>
		       			     <option>Republican</option>
					     <option>Independant</option>
			    		     <option>Libertarian</option>
			    		     <option>Green</option>
		            
		        		</select>
                			@if($errors->has('sex'))
							<label style="color:red;">{{$errors->first('sex')}}</label>
						@endif
		        		<label class="radio-inline">
		        			<input type="radio" name="sex" id="sex" value="male">
		            			Male
		        		</label>
					<label class="radio-inline">
					    <input type="radio" name="sex" id="sex" value="female">
					    Female
					</label>
				
                			@if($errors->has('bio'))
							<label style="color:red;">{{$errors->first('bio')}}</label>
						@endif
					<textarea type="text" placeholder="Biography..." class="form-control" id="bio" name="bio" style="height: 50px;"></textarea>
					
                                
                
                			<button class="btn btn-lg btn-block light" type="submit">Submit</button>
                    		</div>
	</div>
       </form>
        </div>
        
      </div>
      </section>
  </section>

@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
