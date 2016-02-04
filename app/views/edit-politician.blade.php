@include('header')
  <section id="pageContainer" class="section">
  <section id="intro">
    <div class="container edit-politicians">
      <div class="row">
        
        <div class="col-sm-3">
	<h3>Upload Politician Photo</h3>
          <div id="imagePreview" class="politician" title="" style="background-image: url('{{$politician->pic_url}}');"></div>
           <form action="" method="post" class="form" id="edit-politician" enctype="multipart/form-data" role="form">
           <input type="hidden"  id="image_uploaded" name= "image_uploaded" value="false">
	  <input type="file" name="photo" id="photo" class="img">
        </div>
        
        <div class="col-sm-3">
          <h1 >{{$politician->full_name}}</h1>
	  @if(Auth::user()->role=='admin') 
	  	<h2><a href="{{URL::route('profile-politician',$politician->full_name)}}">VIEW PROFILE</a></h2>
	  @endif	
          <h2>{{$politician->office}}</h2>
          <h3>{{$politician->district}}</h3>
          
          

                           
	 
	<a href="{{URL::route('create-politician')}}" class="btn btn-lg create-politician-btn" id="new-politician">Submit New Politician</a>
        </div>
        
        <div class="col-sm-6">

		<input type="hidden" name="politician_id" id="politician_id" value="{{$politician->id}}">
                				<div class="row">
   
                 				<div class="col-xs-6 col-md-6">
			                        	<input class="form-control" value="{{$politician->first_name}}" id="first_name" name="first_name" placeholder="First Name" type="text"  |="" autofocus="">
                    				</div>
						<div class="col-xs-6 col-md-6">
							<input class="form-control" value="{{$politician->last_name}}" id="last_name" name="last_name" placeholder="Last Name" type="text" |="">
					</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$politician->office}}" id="office" name="office" placeholder="Office" type="text" |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$politician->district}}" id="district" name="district" placeholder="District" type="text" |="">
                    			</div>
			
                		</div>
				<div class="row">
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$politician->city}}" id="city" name="city" placeholder="City" type="text"  |="" autofocus="">
                    			</div>
                    			<div class="col-xs-6 col-md-6">
                        			<input class="form-control" value="{{$politician->state}}"  id="state" name="state" placeholder="State" type="text"  |="">
                    			</div>
			
                		</div>
	

               			<select class="form-control" name="party" id="party">
				<?php $options = array('Party','Democrat','Republican','Independant','Liberatarian','Green');?>
				@foreach($options as $option)
				 <option  @if($politician->party == $option) selected @endif>{{$option}}</option>
				@endforeach
               			    
                		</select>
                
                		<label class="radio-inline">
                			<input type="radio" name="sex" id="sex" value="male" @if($politician->sex == 'male') checked @endif>
                    			Male
                		</label>
				<label class="radio-inline">
				    <input type="radio" name="sex" id="sex" value="female" @if($politician->sex == 'female') checked @endif>
				    Female
				</label>
                
		<textarea type="text"  placeholder="Biography..." class="form-control" id="bio" name="bio" style="height: 50px;">{{$politician->bio}}</textarea>
		<label style="color:red;">Admin Approved?</label>		
		<select class="form-control" name="approved" id="approved">
				 <option  @if($politician->approved == 'yes') selected @endif>yes</option>
				 <option  @if($politician->approved == 'no') selected @endif>no</option>
       			    
                </select>
                                
                
                <button class="btn btn-lg btn-block light" id="edit-politician-button" type="submit">Submit</button><br>
		<a style="float:right;" data-href="delete.php?id=23" data-toggle="modal" data-target="#confirm-delete" href="#">Delete Politician</a>
                    
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
                    <p>You are about to <i>permanently</i> delete Politician <b>{{$politician->full_name}}</b></p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="politician-delete" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
