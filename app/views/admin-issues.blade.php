@include('header')
<style type="text/css">
a{text-decoration:underline;}
#results{padding-top: 0px !important;margin-top: -36px;}
.create-issue-btn {
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
					<a data-toggle="modal" data-target="#create-issue" href="#" class="btn btn-lg create-issue-btn" id="new-issue">Submit New Issue</a>
				</div>
			</div>
			@endif

			<div class="table-responsive">
				{{ $issues->links() }}
				
				
				<table id="issue-edit-table" class="table">
					<thead>
						 <tr style="border:1px;border-color:black;">
						    <th>Id</th>
						    <th>Issue Name</th>
						    <th>Created At</th>
						    <th>Created By</th>
						    <th>Number of Followers</th>
						    <th>Delete</th>

						    
						   </tr>
						</thead>
						<tbody>
						@foreach ($issues as $issue) 

						<tr>
						    <td>{{$issue->id}}</td>
						    <td><a data-toggle="modal" data-target="#edit-issue" class ="issue-edit-link" href="{{$issue->issue_name}}-{{$issue->id}}" >{{$issue->issue_name}}</a></td>
   						    <td>{{$issue->created_at}}</td>
   						    <td>{{User::find($issue->created_by)->username}}</td>
						    <td>{{IssueFollow::where('issue_id','=',$issue->id)->count()}}</td>	
					  	    <td><a data-toggle="modal" data-target="#delete-issue" class ="issue-delete-link" href="{{$issue->issue_name}}-{{$issue->id}}">Delete</a></td>					  
						</tr>
			    
						@endforeach
						</tbody>
				</table>
			{{ $issues->links() }}
			</div>
		</section>   
	</div>
</section><!-- #pageContainer -->


<div class="modal fade" id="delete-issue" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                </div>
            <div class="modal-body">
		     <input id="delete-issue-id" value="" type="hidden">
		     <input id="delete-issue-name" value="" type="hidden">
                    <p>You are about to <i>permanently</i> delete Issue <b><span id="delete-issue-span"></span></b></p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" id="issue-delete-cancel" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="issue-delete-button" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>

<div class="modal fade" id="create-issue" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                    <button id="new-issue-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Create New Issue</h4>
                </div>
            <div class="modal-body">
                    <p><input class="form-control" name="issue_name" id="issue_name" placeholder="Issue Name" type="text" |="" autofocus=""></p>
                    
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button id="new-issue-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a  id="new-issue-submit" class="btn btn-danger danger">Submit</a>
                </div>
        </div>
    </div>
</div>
<div class="modal fade" id="edit-issue" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
	<form>
		<div class="modal-content">
		    <div class="modal-header">
		            <button id="new-issue-close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		            <h4 class="modal-title" id="myModalLabel">Edit Issue</h4>
		        </div>
		    <div id="edit-modal-body" class="modal-body">
		            <input id="issue_id" value="" type="hidden">
			<input class="form-control" name="edit-issue-input" id="edit-issue-input" placeholder="Issue Name" type="text">
		            
		            <p class="debug-url"></p>
		        </div>
		     <div class="modal-footer">
		            <button id="new-issue-cancel" type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
		            <a  id="edit-issue-submit" class="btn btn-danger danger">Submit</a>
		        </div>
		</div>
`	</form>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
