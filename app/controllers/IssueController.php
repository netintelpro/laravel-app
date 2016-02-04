<?php
class IssueController extends BaseController{

	public function getNews()
	{
		$issue_id = Input::get('issue_id');
		$issue = Issue::find($issue_id);
		$user_id = Input::get('user_id');
		$politician_id = Input::get('politician_id');
		$politician = Politician::find($politician_id);
		$news = $issue->googleNews($politician->full_name);


		$date = new DateTime;
		$date->modify('-1 hour');
		$formatted_date = $date->format('Y-m-d H:i:s');
		$sum = Rating::where('user_id','=',$user_id)
					->where('politician_id','=',$politician->id)
					->where('issue_id','=',$issue->id)->where('created_at','>=',$formatted_date)->sum('value');
					
		$response = array('sum' => $sum,'news' => $news);
		return Response::json($response);
	
	}

	public function deleteIssue()
	{
		if (Auth::user()->isAdmin())
		{
		
		

			$issue_id = Input::get('issue_id');


			$deletedRatings = Rating::where('issue_id', '=', $issue_id)->delete();
			$deletedIssueFollows = IssueFollow::where('issue_id', '=', $issue_id)->delete();


			$issue = Issue::find($issue_id);
			$issue->delete();

		}
		else return App::abort(404);

	}

	public function updateIssue()
	{
		$issue_name = Input::get('issue_name');
		$issue_id = Input::get('issue_id');

		$already_created = Issue::where('issue_name','=',$issue_name);



		if (!($already_created->count() >0))//if issue already exists
		   {			
			if(isset($issue_name))
			{
				$issue = Issue::find($issue_id);
				$issue->issue_name = $issue_name;
				$issue->save();
				return null;// Response::json(array('issue_name'=>'A WEALTH','issue_id'=>$issue_id));
			}
		   }
		else //return Response::json(array('issue_name'=>'B WEALTH','issue_id'=>$issue_id));
			return Response::json(array('issue_name'=>$already_created->first()->issue_name));
		
		//return Response::json($return);
	}	






	public function newIssue()
	{
		$issue_name = Input::get('issue_name');

		$already_created = Issue::where('issue_name','like','%'.$issue_name.'%');


		$return = array('1'=>'1','2'=>'2');
		if (!($already_created->count() >0))//if issue already exists
		   {			
			if(isset($issue_name))
			{
				$issue = Issue::create(array(
								'issue_name'=> $issue_name,
								'created_by'=> Auth::user()->id));
				$issue->save();
				return null;
			}
		   }
		else 
			return Response::json(array('issue_name'=>$already_created->first()->issue_name));
		
		//return Response::json($return);
	}	



	public function adminlistIssues()
	{
		if (Auth::user()->isAdmin())
		{
			$issues = DB::table('issues')->orderBy('id', 'desc')->paginate(30);
			return  View::make('admin-issues')->with('issues',$issues);
		}
		else return App::abort(404);

	}

	public function createIssue()
	{
		if (Auth::user()->isAdmin())
			{
				return View::make('create-issue');
			}
		else return App::abort(404);
	}
	
	

	

	
	

	

     
}

?>

	
