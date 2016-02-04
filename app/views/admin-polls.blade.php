@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-poll-btn {
margin-top: 69px !important;
margin-bottom: 23px;
}
td{border: 1px solid #ddd;}
</style>
<section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
			@if(Auth::user()->isAdmin())
			<div class ="row" style="text-align:center;">
				<div >
					<a data-toggle="modal" data-target="#create-poll" href="#" class="btn btn-lg create-poll-btn" id="new-poll">Create New Poll</a>
				</div>
			</div>
			@endif

			<div class="table-responsive">
				{{ $polls->links() }}
				
				
				<table id="poll-edit-table" class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						    <th>Id</th>
						    <th>Title</th>
						    <th>Created At</th>
						    <th>Created By</th>
						    <th>Delete</th>

						    
						   </tr>
						</thead>
						<tbody>
						@foreach ($polls as $poll) 

						<tr>
						    <td>{{$poll->id}}</td>
						    <td><a href="{{URL::route('edit-poll',$poll->title)}}" >{{$poll->title}}</a></td>
   						    <td>{{$poll->created_at}}</td>
   						    <td>{{User::find($poll->created_by)->username}}</td>
					  	    <td><a data-toggle="modal" data-target="#delete-poll" class ="poll-delete-link" href="{{$poll->title}}-{{$poll->id}}">Delete</a></td>					  
						</tr>
			    
						@endforeach
						</tbody>
				</table>
			{{ $polls->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->


<div class="modal fade" id="delete-poll" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            <div class="modal-body">
		     <input id="delete-poll-id" value="" type="hidden">
		     <input id="delete-poll-title" value="" type="hidden">
                    <p>You are about to <i>permanently</i> delete Poll <b><span id="delete-poll-span"></span></b></p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" id="poll-delete-cancel" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="poll-delete-button" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create-poll" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button id="new-poll-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Create New Poll</h4>
                </div>
            <div class="modal-body">
                    <p><input class="form-control" name="poll_title" id="poll_title" placeholder="Poll Name" type="text" |="" autofocus=""></p>
                    
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button id="new-poll-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a  id="new-poll-submit" class="btn btn-danger danger">Submit</a>
                </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-poll" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<form>
		<div class="modal-content">
		    <div class="modal-header">
		            <button id="new-poll-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">Edit Poll</h4>
		        </div>
		    <div id="edit-modal-body" class="modal-body">
		            <input id="poll_id" value="" type="hidden">
			<input class="form-control" name="edit-poll-input" id="edit-poll-input" placeholder="Poll Title" type="text">
		            
		            <p class="debug-url"></p>
		        </div>
		     <div class="modal-footer">
		            <button id="new-poll-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
		            <a  id="edit-poll-submit" class="btn btn-danger danger">Submit</a>
		        </div>
		</div>
`	</form>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
