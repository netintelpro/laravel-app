<?php
class PollController extends BaseController{


	public function adminlistPolls()
	{
		if (Auth::user()->isAdmin())
		{
			$polls = DB::table('polls')->orderBy('id', 'desc')->paginate(30);
			return  View::make('admin-polls')->with('polls',$polls);
		}
		else return App::abort(404);

	}

	public function editPoll($title)
	{

		if (Auth::user()->isAdmin())
		{
			$poll= Poll::where('title','=',$title)->first();
			return View::make('edit-poll')
				->with('poll',$poll);
		}
		else return App::abort(404);
	}

	
	public function deletePoll()
	{
		if (Auth::user()->isAdmin())
		{
		
		

			$poll_id = Input::get('poll_id');
			$poll = Poll::find($poll_id);
			$poll->delete();

		}
		else return App::abort(404);

	}

	public function deleteQuestion()
	{
		if (Auth::user()->isAdmin())
			{
				$question_id = Input::get('question_id');
				$question = Question::find($question_id);
				$question->delete();
			}	
	}

	public function deleteAnswer()
	{
		if (Auth::user()->isAdmin())
			{
				$answer_id = Input::get('answer_id');
				$answer = Answer::find($answer_id);
				$answer->delete();
			}	
	}

	public function updatePoll()
	{
		$poll_title = Input::get('poll_title');
		$poll_id = Input::get('poll_id');
		$new_poll_questions = Input::get('new_poll_questions');

		$new_poll_questions_count = count($new_poll_questions);
		$poll = Poll::find($poll_id);

		

	
		if(isset($poll_title))
			{

				$poll->title = $poll_title;
				$poll->save();


			}

		for($i=0;$i<$new_poll_questions_count;$i++)
			if(isset($new_poll_questions[$i])){
					$question = Question::create(array('created_by'=>Auth::user()->id,'content'=>$new_poll_questions[$i],'poll_id'=>$poll_id));
					$question->save();
				}
		foreach($poll->questions as $question)
		{
				$save_question = Question::find($question->id);
				$save_question->content = Input::get('question-'.$question->id);
				$save_question->save();	



				foreach($question->answers as $answer)
				{
					$save_answer = Answer::find($answer->id);
					$save_answer->content = Input::get('answer-'.$answer->id);	
					$save_answer->save();			
				}

				$new_poll_answers = Input::get('new_poll_answers-'.$question->id);
				if(isset($new_poll_answers))
				{
					$new_poll_answers_count = count($new_poll_answers);
					for($i=0;$i<$new_poll_answers_count;$i++)
						if(isset($new_poll_answers[$i]))
							{
								$answer = Answer::create(array(
									'created_by'=>Auth::user()->id,
									'content'=>$new_poll_answers[$i],
									'question_id'=>$question->id));
								$answer->save();
							}	

				}
				
					
		}	
			

				
		return Redirect::action('PollController@editPoll', array('title' => $poll_title));


	//	return View::make('edit-poll')
	//			->with('poll',$poll);
	}	






	public function newPoll()
	{
		$title = Input::get('title');

		$already_created = Poll::where('title','like','%'.$title.'%');


		if (!($already_created->count() >0))//if poll already exists
		   {			
			if(isset($title))
			{
				$poll = Poll::create(array(
								'title'=> $title,
								'created_by'=> Auth::user()->id));
				$poll->save();
				return null;
			}
		   }
		else 
			return Response::json(array('title'=>$already_created->first()->title));
		
		//return Response::json($return);
	}	



	
	public function createPoll()
	{
		if (Auth::user()->isAdmin())
			{
				return View::make('create-poll');
			}
		else return App::abort(404);
	}
	
public function getQuestion($id)
	{
		$question = Question::find($id);
		$fb_og = array('url'=>Request::url() , 'title'=>$question->content,'description'=>$question->content);
		return View::make('question')->with('question',$question);
			
	}

	
public function submitQuestion()
	{
		$answer_id = Input::get('answer_id');
		
		$user_answer = UserAnswer::create(array('answer_id'=> $answer_id,'user_id'=> Auth::user()->id));
		$user_answer->save();
		return View::make('question-chart')->with('question',Answer::find($answer_id)->question);
	}
	
	

	

     
}

?>

	
