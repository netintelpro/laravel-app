@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-comment-btn {
margin-top: 69px !important;
margin-bottom: 23px;
}
td{border: 1px solid #ddd;}
</style>
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
			

			<div class="table-responsive">
				{{ $comments->links()}}
				
				
				<table id="comment-edit-table" class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						<th>Id</th>
						<th>Created By</th>
						<th>About/Politician</th>	
					    	<th>Content</th>
						<th>Parent</th>
					        <th>Responses</th>
						<th>Created At</th>
						<th>Delete</th>

						    
						   </tr>
						</thead>
						<tbody>
						@foreach ($comments as $comment) 
                                                <?php 
							$username = User::find($comment->user_id)->username;
							$politician_name = Politician::find($comment->politician_id)->full_name;

						?>

	
							<tr>
							      <td>{{$comment->id}}</td>
	   						    <td><a href="{{URL::route('profile-user',$username)}}" >{{$username}}</a></td>
							    <td><a href="{{URL::route('profile-politician',$politician_name)}}">{{$politician_name}}</a></td>
							    <td><a id ="{{'content-'.$comment->id}}" href="{{'http://iratepolitics.com/politicians/'.$politician_name.'/#'.$username.'-'.$comment->id}}">{{$comment->content}}</a></td>
							    <td>{{$comment->parent_id}}</a></td>
							    <td>{{Comment::where('parent_id','=',$comment->id)->count()}}</td>	
	   						    <td>{{$comment->created_at}}</td>
						  	    <td><a data-toggle="modal" data-target="#delete-comment" class ="comment-delete-link" href="{{$comment->id}}">Delete</a></td>					  
							</tr>
						
			    
						@endforeach
						</tbody>
				</table>
			{{$comments->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->


<div class="modal fade" id="delete-comment" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            <div class="modal-body">
		     <input id="delete-comment-id" value="" type="hidden">

                    <p>You are about to <i>permanently</i> delete comment:<br><i> <b><span id="delete-comment-span"></span></b></i></p>
		   <p>And all Replies</p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" id="comment-delete-cancel" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="comment-delete-button" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create-comment" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button id="new-comment-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Create New comment</h4>
                </div>
            <div class="modal-body">
                    <p><input class="form-control" name="comment_title" id="comment_title" placeholder="comment Name" type="text" |="" autofocus=""></p>
                    
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button id="new-comment-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a  id="new-comment-submit" class="btn btn-danger danger">Submit</a>
                </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-comment" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<form>
		<div class="modal-content">
		    <div class="modal-header">
		            <button id="new-comment-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">Edit comment</h4>
		        </div>
		    <div id="edit-modal-body" class="modal-body">
		            <input id="comment_id" value="" type="hidden">
			<input class="form-control" name="edit-comment-input" id="edit-comment-input" placeholder="comment Title" type="text">
		            
		            <p class="debug-url"></p>
		        </div>
		     <div class="modal-footer">
		            <button id="new-comment-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
		            <a  id="edit-comment-submit" class="btn btn-danger danger">Submit</a>
		        </div>
		</div>
`	</form>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
