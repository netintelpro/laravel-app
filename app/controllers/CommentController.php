<?php
class CommentController extends BaseController{


	public function deleteComment()
	{
			if (Auth::user()->isAdmin())
			{
				$comment_id = Input::get('comment_id');
				$comment = Comment::find($comment_id);

				//delete all comment replies
				$replies = $comment->replies;
				if ($replies->count())
					foreach($replies as $reply)
						$reply->delete();
					
				$comment->delete();
			}

	}
	
	public function rantSubmit()
	{
		$validator = Validator::make(Input::all(),array('auto-politician'=>'required|min:3'));
		if($validator->fails())
		{
				return Redirect::route('home')
				->withErrors($validator)
				->withInput();
		}
        		else
			{	

				$auto_politician = Input::get('auto-politician');
				$rant = Input::get('rant');
		
				if(Auth::check())
				{

					$search_query = '%'.$auto_politician.'%';			
					$politician = Politician::where('full_name','like',$search_query)->first();

					$rant = Input::get('rant');
		
					$comment = Comment::create(array( 
					 	'content'      =>$rant,
					 	'politician_id'=>$politician->id,
					 	'user_id'      =>Auth::user()->id,
					 	'parent_id'    =>0));

					$comment->save();
					return Redirect::to('/politicians/'.$comment->politician->full_name.'/#'.$comment->user->username.'-'.$comment->id);
				}
				else
				   {
					//return Redirect::route('create-get-1', array('auto-politician' =>$auto_politician_name,'rant'=>$rant));
					return View::make('create-1')->with('rant_data', array('auto-politician'=>$auto_politician,'rant'=> $rant));
				   }
			}
	}
	public function voteComment()
	{
		$value = Input::get('value');
		$comment_id = Input::get('comment_id');
		$user_id = Auth::user()->id;
                $consecutive_same_vote = false;

		$comment = Comment::find($comment_id);
                //we don't want user making more then 1 vote up or down. 
		//if vote is up and already up vote, then vote is converted to down and vice versa
		if ($value == 1)
		{
			$positive_likes = $comment->likes()->where('user_id','=',$user_id)->where('value','=','1')->get();
			if ($positive_likes->count())
			{
				$positive_likes->first()->delete();

				$consecutive_same_vote = true;
			}
		}
		else if($value==-1)
		{
			$negative_likes =$comment->likes()->where('user_id','=',$user_id)->where('value','=','-1')->get();
			if($negative_likes->count())
			{
				$negative_likes->first()->delete();
				$consecutive_same_vote = true;
			}
		}
		if (!($consecutive_same_vote))
		{
			$like = Like::create(array(
				'value'      => $value,
				'user_id'    => $user_id,
				'comment_id' => $comment_id));
			$like->save();
		}
	        //calculate rank
		$rank = $comment->likes()->sum('value');
                
                
		

		$comment->rank = $rank;

		$comment->save();

		if ($value == -1)
			$count = $comment->likes()->where('value','=','-1')->get()->count();
			
		else 	$count = $comment->likes()->where('value','=','1')->get()->count();


		//email notification
		if ($comment->user->rank_notice)
		{
				if ($value==-1) 
					$vote =" up "; 
				else $vote =" down ";
				$message = "You're comment has been voted";				
				$message .= $vote."!\n ";
				if ($comment->parent_id != 0)
					$parent_comment = $comment->parent;
				else
					$parent_comment = $comment;
				$message .= str_replace(' ', '%20','http://iratepolitics.com/politicians/'.$parent_comment->politician->full_name.'/#'.$parent_comment->user->username.'-'.$parent_comment->id);
				

				$message .= "\n\n\nTo disable comment response, uncheck 'Receive email notice of up/down votes on my comments.' here: ";
				$message .= URL::route('edit-myprofile');				
				$subject = "Someone has voted".$vote."your comment!";
		    		// message lines should not exceed 70 characters (PHP rule), so wrap it
		    		$message = wordwrap($message, 70);
				mail($parent_comment->user->email,$subject,$message,"From: contact@iratepolitics.com\n");
	
		}

		//return $count;//rand(1,10); //from old arangement counting likes up and down
		return $rank; //new arrangement returning comment rank
	

	}


	public function submitComment()
	{
                $comment = Comment::create(array( 
		 	'content'      =>Input::get('content'),
		 	'politician_id'=>Input::get('politician_id'),
		 	'user_id'      =>Auth::user()->id,
		 	'parent_id'    =>Input::get('parent_id')));
		$comment->save();
		//this might seem redundant...why not just send $comment? 
		//because of our js functions, we need to send a list of comment objects that only contain one object
		//return json_encode(Comment::find($comment->id));
		


		//authorize and make comment notifications


		//notify parent commentator of responses
		$parent_id = Input::get('parent_id');
		if ($parent_id != 0) 
		{
			$parent_comment = Comment::find($parent_id);
			$parent_user = $parent_comment->user;
			if ($parent_user->response_notice)
			{
				
				$message = "A response has been made to your comment here:\n ";
				$message .= str_replace(' ', '%20','http://iratepolitics.com/politicians/'.$parent_comment->politician->full_name.'/#'.$parent_comment->user->username.'-'.$parent_comment->id);
				$message .= "\n\n\nTo disable comment response, uncheck 'Receive email notice of responses to my comments.' here: ";
				$message .= URL::route('edit-myprofile');				
				$subject = "Someone has responded to your comment!";
		    		// message lines should not exceed 70 characters (PHP rule), so wrap it
		    		$message = wordwrap($message, 70);
				mail($parent_user->email,$subject,$message,"From: contact@iratepolitics.com\n"); 
			}
		//notify thread followers of responses

			foreach($parent_comment->replies as $reply)
			{
				if($reply->user->thread_notice)
				{
				$message = "A response has been made to conversation you are following here:\n ";
				$message .= str_replace(' ', '%20','http://iratepolitics.com/politicians/'.$parent_comment->politician->full_name.'/#'.$parent_comment->user->username.'-'.$parent_comment->id);
				$message .= "\n\n\nTo disable conversation response, uncheck ' Receive email notice of new comments on thread.' here: ";
				$message .= URL::route('edit-myprofile');				
				$subject = "Update to conversation you're following!";
		    		// message lines should not exceed 70 characters (PHP rule), so wrap it
		    		$message = wordwrap($message, 70);
				mail($reply->user->email,$subject,$message,"From: contact@iratepolitics.com\n");
				}
			}
		}
		






		$comment = $comment->toArray();
			$comment = array_merge(array(
			'rankup'   => 0,
			'rankdown' => 0
				),$comment);
		return json_encode($comment);
		
	}

	public function getReplies()
	{
		$comment_id = Input::get('comment_id');
		$comments = Comment::find($comment_id)->replies()->orderBy('rank', 'desc')->orderBy('created_at', 'desc')->get();
		
		$comment_array = array();
					
		foreach($comments as $comment)
		{

			$rankup = $comment->likes()->where('value','=', '1')->get()->count();
			if (!isset($rankup)) $rankup = 0;

			$rankdown = $comment->likes()->where('value','=','-1')->get()->count();
			if (!isset($rankdown)) $rankdown = 0;
			$comment = $comment->toArray();
			$comment = array_merge(array(
			'rankup'   => $rankup,
			'rankdown' => $rankdown
				),$comment);
			array_push($comment_array,$comment);
			
			
		}
	
		return json_encode($comment_array);	

	}


	public function getComment(){
		
	}

	public function issueVote(){
		

	}

	public function follow(){
              

		}
	public function adminlistComments()
	{
	
if (Auth::user()->isAdmin())
		{
			$comments = DB::table('comments')->orderBy('id', 'desc')->paginate(30);
			return  View::make('admin-comments')->with('comments',$comments);
		}
		else return App::abort(404);
	}
			

}//CommentController
?>
