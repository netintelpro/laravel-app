@include('header')
  <section id="pageContainer" class="section">
  <section id="intro">
    <div class="container edit-user">
      <div class="row">
        
        <div class="col-sm-3">
	<h3>Upload Photo</h3>
          <div id="imagePreview" class="politician" title="" style="background-image: url('{{$user->pic_url}}');"></div>
           <form action="" method="post" class="form" id="edit-user" enctype="multipart/form-data" role="form">
           <input type="hidden"  id="image_uploaded" name= "image_uploaded" value="false">
	  <input type="file" name="photo" id="photo" class="img">
        </div>
        <div class="col-sm-3">
		  <h1 >{{$user->username}}</h1>
		  @if(Auth::user()->role=='admin') 
		  	<h2><a href="{{URL::route('profile-user',$user->username)}}">VIEW PROFILE</a></h2>
		  	
		  	<h2>{{"Created At: ".$user->created_at}}</h2>
		  	<h2>{{"Last Login: ".$user->last_login_at}}</h2>
		 	 <h2>{{"Last Log out: ".$user->last_logout_at}}</h2>
		  	<h2>{{"Last IP Address: ".$user->last_ip_address}}</h2>
		  
		  @endif
		<a href="{{URL::route('create-user')}}" class="btn btn-lg create-user-btn" id="new-user">Create New User</a>
        </div>
        <div class="col-sm-6">
	<input type="hidden" name="user_id" id="user_id" value="{{$user->id}}">
                				<div class="row">
   
                 				<div class="col-xs-6 col-md-6">
			                        	<input class="form-control" value="{{$user->first_name}}" id="first_name" name="first_name" placeholder="First Name" type="text"  |="" autofocus="">
                    				</div>
						<div class="col-xs-6 col-md-6">
							<input class="form-control" value="{{$user->last_name}}" id="last_name" name="last_name" placeholder="Last Name" type="text" |="">
					</div>

						<div class="col-xs-6 col-md-6">
							<input class="form-control" value="{{$user->email}}" id="email" name="email" placeholder="Email" type="text" |="">
					</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
				@if(Auth::user()->isAdmin())
					<select class="form-control" name="role" id="role">
				
					<?php $options = array('regular','admin');?>
					@foreach($options as $option)
					 <option  @if($user->role == $option) selected @endif>{{$option}}</option>
					@endforeach
		       			    
		        		</select>
				@endif
                    			</div>
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$user->birth_day}}" id="birth_day" name="birth_day" placeholder="Birth Day" type="text" |="">
						<input class="form-control" value="{{$user->birth_month}}" id="birth_month" name="birth_month" placeholder="Birth Month" type="text" |="">
						<input class="form-control" value="{{$user->birth_year}}" id="birth_year" name="birth_year" placeholder="Birth Year" type="text" |="">                    			
					</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$user->city}}" id="city" name="city" placeholder="City" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
						<select class="form-control" name="state" id="state">
							@foreach(State::all() as $state)
						 		<option  @if($user->state == $state->title) selected @endif>{{$state->title}}</option>
							@endforeach
                        			</select>
                    			</div>
			
                		
					<div class="col-xs-6 col-md-6">
					<select class="form-control" name="party" id="party">
							<?php $options = array('Party','Democrat','Republican','Independant','Liberatarian','Green');?>
							@foreach($options as $option)
								 <option @if($user->party == $option) selected @endif >{{$option}}</option>
							@endforeach
	               			    
		                	</select>
					</div>
				</div>
	

               			
                
                		<label class="radio-inline">
                			<input type="radio" name="sex" id="sex" value="male" @if($user->sex == 'male') checked @endif>
                    			Male
                		</label>
				<label class="radio-inline">
				    <input type="radio" name="sex" id="sex" value="female" @if($user->sex == 'female') checked @endif>
				    Female
				</label>
                
		<textarea type="text"  placeholder="Biography..." class="form-control" id="bio" name="bio" style="height: 50px;">{{$user->bio}}</textarea>
		
                                
                
                <button class="btn btn-lg btn-block light" id="edit-user-button" type="submit">Submit</button><br>
		<a style="float:right;" data-href="delete.php?id=23" data-toggle="modal" data-target="#confirm-delete" href="#">Delete User</a>
                    
             </form>
        </div>
        
      </div>
    </div>
  </section>
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            <div class="modal-body">
                    <p>You are about to <i>permanently</i> delete User <b>{{$user->username}}</b></p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="user-delete" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
