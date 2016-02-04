@include('header')
  <section id="pageContainer" class="section">
	<div class="container">
		<section id="results">
		      <div class="row">
		
			       
			<div id="edit-poll"style="margin-left:10%;width:80%;" class="text-center">
					 <form action="" method="post" class="form" id="edit-poll-form" enctype="multipart/form-data" role="form">
					<label class="pull-left">Poll Title</label>					
					<input type="hidden" name="poll_id" id="poll_id" value="{{$poll->id}}">
				       <input class="form-control" value="{{$poll->title}}" id="poll_title" name="poll_title" placeholder="Poll Title" type="text"  |="" autofocus="">
					 
					<div class="input_fields_wrap">
					@foreach($poll->questions as $question)
					<div class="row">
						<div class="form-group" id="group-{{$question->id}}">
							<label class="pull-left">Poll Question</label>
							<input class="form-control" style="width:90%;float:left;" value="{{$question->content}}" 
							id="question-{{$question->id}}" name="question-{{$question->id}}" placeholder="New Question" type="text">
							<a href="{{$question->id}}" style="padding: 10px;float:right;"class="remove_field">Remove</a>
							<a href="{{URL::route('question',$question->id)}}">Question Url</a>
							<div id="answer-col-{{$question->id}}" class="answer-col col-sm-2 pull-right" style="width:43% !important;">
								@foreach($question->answers as $answer)
								<div class="row">
									<div class="answer-form-group">

										<input class="form-control" style="width:75%;float:left;" value="{{$answer->content}}" 
										id="answer-{{$answer->id}}" name="answer-{{$answer->id}}"

									placeholder="New Question" type="text"><a href="{{$answer->id}}" style="padding: 10px;float:right;"class="remove_answer_field">Remove</a>
									</div>
								</div>
								@endforeach
							</div>
							<a href="{{$question->id}}" class="add-new-answer btn btn-tag" style="float:right;">Add New Answer</a>

						</div> 
					</div>
					@endforeach   
			</div>
		<div class="col-sm-3">
            <a id="add-new-answer-btn" class="btn btn-lg pull-right">Add New Question</a>
          </div> 
						<button class="btn btn-lg btn-block light" id="edit-poll-button" type="submit">Submit</button><br>
						<a style="float:right;" data-href="delete.php?id=23" data-toggle="modal" data-target="#confirm-delete" href="#">Delete Poll</a>
						    
					     </form>
			</div>
		
		      </div>
      		</section>
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
                    <p>You are about to <i>permanently</i> delete Poll <b>{{$poll->title}}</b></p>
                    <p>Are you sure you want to proceed?</p>
                    <p class="debug-url"></p>
                </div>
             <div class="modal-footer">
                    <button type="button" class="btn btn-default cancel" data-dismiss="modal">Cancel</button>
                    <a href="#" id="poll-delete" class="btn btn-danger danger">Delete</a>
                </div>
        </div>
    </div>
</div>
@include('footer',array('chart'=>'false','issue_tag_cloud'=>'null'))
