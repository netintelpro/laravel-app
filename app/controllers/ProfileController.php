<?php
class ProfileController extends BaseController{
	
	
	public function listUsers()
	{
			$users = DB::table('users')->orderBy('id', 'desc')->paginate(30);


			return  View::make('users')->with('users',$users);

	}

	public function adminlistUsers()
	{
		if (Auth::user()->isAdmin())
		{
			
			$users = DB::table('users')->orderBy('id', 'desc')->paginate(30);


			return  View::make('admin-users')->with('users',$users);
		}
		else return App::abort(404);

	}

	public function createUser()
	{
	if (Auth::user()->isAdmin())
	{
		return View::make('create-user');
	}
		else return App::abort(404);
	}
	
	public function newUser()
	{
		$user_id = Input::get('user_id');
		$admin_update = (Auth::user()->id==$user_id);	
		if ((Auth::user()->isAdmin())||$admin_update)
		{
			$user = User::create(array(
						'username'=> Input::get('username'),
						'first_name'=> Input::get('first_name'),
						'last_name'=> Input::get('last_name'),
						'password'=> Input::get('password'),
						'sex'=> Input::get('role'),
						'party'=> Input::get('party'),
						'city'=> Input::get('city'),
						'bio'=> Input::get('bio'),
						'state'=> Input::get('state'),
						'sex'=> Input::get('sex'),
						'birth_month' => Input::get('birth_month'),
						'birth_date' => Input::get('birth_date'),
						'birth_year' => Input::get('birth_year')

						/*'bw_pic_url' => $bw_pic_url */));
			$user->save();
			return Redirect::action('ProfileController@adminlistUsers');

				
		}
		else return App::abort(404);		



	}

	public function deleteUser()
	{
		//dont forget to delete image file...look up  ^ for file save code

	if (Auth::user()->isAdmin())
		{
		

			$user_id = Input::get('user_id');
			$user = User::find($user_id);
			if (isset($user->pic_url))
				if( (file_exists(public_path().$user->pic_url))
					&&($user->pic_url !='/assets/images/avatars/default/default-avatar.jpg'))
				{
		    				unlink(public_path().$user->pic_url); // Delete now
				}

			/****delete comments*****/
			$comments = $user->comments;
			foreach($comments as $comment)
				$comment->delete();

			$user_follows = UserFollow::where('following_id','=',$user->id)->get();
			foreach($user_follows as $follow)
				$follow->delete();
			
			$ratings = $user->ratings;
			foreach($ratings as $rating)
				$rating->delete();

			
			$user->delete();

	
			return Redirect::action('ProfileController@adminlistUsers');
		}
		else return App::abort(404);

	}
	
	
	public function updateUser()
	{
		$user_id = Input::get('user_id');
		$admin_update = (Auth::user()->id==$user_id);	
		if ((Auth::user()->isAdmin())||$admin_update)
		{
			$user = User::find($user_id);
			$user->email = Input::get('email');

			$user->role = Input::get('role');
			$user->bio = Input::get('bio');
			$user->first_name = Input::get('first_name');
			$user->last_name = Input::get('last_name');
			$user->party = Input::get('party');
			$user->city = Input::get('city');
			$user->state = Input::get('state');
			$user->birth_month = Input::get('birth_month');
			$user->birth_day = Input::get('birth_day');
			$user->birth_year = Input::get('birth_year');
			$user->sex = Input::get('sex');
			
			$user->save();
			return Redirect::action('ProfileController@adminlistUsers');

				
		}
		else return App::abort(404);
	}

	private function get_chart_data($party_name,$user_id)
	{
			//make list of all ids
			$ratings = array();
			

			//Hate to throw tacky direct php mysql queries instead of ORM. But having trouble with
			//ORM query logic for inner joins of derived tables. Need beta now and will ORM later.
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");
                        


		        //Democrat Ratings: Get value and timestamp of all democrat politicians' ratings for this user
                        $query = "select value,r.created_at from (select * from ratings where user_id='".$user_id."') as r inner join (select * from politicians where party='".$party_name."') as p on r.politician_id = p.id";

			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 	$ratings[$i++] = array(
					'value'=>$row['value'],
					'created_at' => $row['created_at']
				);
 				 
				}//close while
						
			mysqli_close($con);

			//we have raw data. now we need to turn data into format for highchart with appropriate time interval resolution
			//For now we are going to use 7 day intervals. So we are going back 7 days from today.
			//0 on x-axis is 7 days ago. 
			
			//creating array where each index represents a day (whatever time unit in future)
			//For now, 0 is 7 days ago. So we loop through each day and sum up all raw data values that took place during
			//that time unit
                     
			$todays_date = new DateTime("now"); 	 	


			$chart_data = array("0"=>"0","1"=>"0","2"=>"0","3"=>"0","4"=>"0","5"=>"0","6"=>"0");			
			foreach ($ratings as $rating) {
				$rate = array();
				$rating_date = new DateTime($rating['created_at']); //echo ' Rating Date: '.$rating_date->format("Y-m-d H:i:s");
				
				$date_interval = $todays_date->diff($rating_date);//echo ' $date_interval: '.$date_interval->format("%a")."days\n";
			        $date_interval = intval($date_interval->format("%a"));			        
				if ($date_interval <=6) 
				{
					$chart_data[6-$date_interval] += $rating['value'];
				}

			}
			return $chart_data;	


	}

	public function updateIssuesFollowed()
	{
		//Make a list of all issues user is currently following. Then check against that list with edit form input
                        //Dont create new issue follow records for old follows
			//Make sure to delete issues un-checked that were previously followed

			$issues_already_followed = Auth::user()->issues;			
			$issues_already_followed_array[] = array();
				
			$i = 0;
			foreach($issues_already_followed as $issue_followed)
			{
				$issues_already_followed_array[$i++] = $issue_followed->id;

			}
	
			$issues = Issue::all();
			foreach($issues as $issue)
			{
				$issue_checkbox = Input::get($issue->id);
				if(in_array($issue->id,$issues_already_followed_array))//if issue is already being followed
				{
					if (!(isset($issue_checkbox)))//issue was being followed previously. Now its unchecked/unfollowed
						{
							/*delete issue follow*/
							$issue_follow =IssueFollow::where('issue_id','=',$issue->id)
									->where('user_id','=',Auth::user()->id);
							$issue_follow->delete();
						}
				}
				else if(isset($issue_checkbox))
					{
						$issue_follow = IssueFollow::create(array(
						'issue_id'=> $issue_checkbox,
						'user_id' => Auth::user()->id));
						$issue_follow->save();
					}
							
			}
		
			//Redirect to login page - added to redirect to home upon successful account 
			return Redirect::route('edit-myprofile','#issues');//issues



	}

	private function uploadImage($last_name)
	{
	//Upload Image


		$file = Input::file('photo');
		if(Input::get('image_uploaded')=="true")
		{
		   	$filename ="";
			$destinationPath    = "";
			$pic_url  = "";
			if (isset($file))
				{
			               if ($file ->isValid())
					{
					$destinationPath    = public_path().'/assets/images/avatars/'; // The destination were you store the image.
						$filename = trim(str_replace(' ','',$last_name)).'.jpg';//$file->getClientOriginalName();
	    			        $file->move($destinationPath, $filename);
					$pic_url = '/assets/images/avatars/'.$filename;
					}
				}
					
			return $pic_url;
		} else{ return null;}
	
	}

	public function postEdit()
	{

			$validator = Validator::make(Input::all(),
			array(
				//'email'          =>'max:50|email|unique:users',
				//'username'       =>'max:20|min:3|unique:users',
				'password'       =>'min:6',
				'password_again' =>'same:password'
                             )
                );
	
	if($validator->fails()){
	//if(false){

			return Redirect::route('edit-myprofile')
			->withErrors($validator)
			->withInput();
	}
        else{		
			$user = Auth::user();	
			$pic_url = $this->uploadImage(Input::get('username'));
			//only want to replace pic url if there is something uploaded in edit form
			if ($pic_url != null)
				$user->pic_url = $pic_url;

			
			$user->email= Input::get('email');
			$user->username = Input::get('username');
			$user->last_name = Input::get('lastname');
			$user->first_name = Input::get('firstname');
			$password = Input::get('password');
			if ($password !="") $user->password = Hash::make($password);
			

			$user->party = Input::get('party');
			$user->bio = Input::get('bio');
			$user->state = Input::get('state');
			$user->city = Input::get('city');

			$user->birth_month = Input::get('birth_month');
			$user->birth_day = Input::get('birth_day');
			$user->birth_year = Input::get('birth_year');
			$user->sex = Input::get('sex');
			$user->response_notice = Input::get('response_notice');
			$user->rank_notice = Input::get('rank_notice');
			$user->thread_notice = Input::get('thread_notice');
			$user->save();
						
			//Redirect to login page - added to redirect to home upon successful account 
			//return Redirect::route('edit-myprofile');
			return Redirect::action('ProfileController@getEdit');

		}//end else
	}// end postEdit()
	public function editUser($username)
	{

		if (Auth::user()->isAdmin())
		{
			$user= User::where('username','=',$username)->first();
			return View::make('edit-user')
				->with('user',$user);
		}
		else return App::abort(404);
	}
	
	public function getEdit()
	{			
				$issues_followed = Auth::user()->issues;			
				$issues_followed_array[] = array();
				
				$i = 0;
				foreach($issues_followed as $issue)
				{
					$issues_followed_array[$i++] = $issue->id;

				}
				return View::make('edit')
				->with('comments',Auth::user()->comments)
				->with('issues',Issue::all())
				->with('issues_followed',$issues_followed_array)
				->with('politicians', Auth::user()->politicians);
	}
	public function myProfile()

	{
		//$politician_follows = PoliticianFollow::where('user_id','=',Auth::user()->id);
		$politicians = User::find(Auth::user()->id)->politicians;

		if (Auth::user()->issues->count()) 
			$issues = Auth::user()->issues;
		else $issues = null;

		if (Auth::user()->comments->count())
			$comments = Auth::user()->comments;
		else $comments = null;
		
		$democrat_chart_data =	$this->get_chart_data('Democrat',Auth::user()->id);
		$republican_chart_data = $this->get_chart_data('Republican',Auth::user()->id);
		
		return View::make('myprofile')
			->with('politicians',$politicians)
			->with('democrat_chart_data',$democrat_chart_data)
			->with('republican_chart_data',$republican_chart_data)
			->with('comments',$comments)
			->with('title','My Profile')
			->with('issues',$issues);
		
	}
	public function politician($name){
		return View::make('politician');
	}

	public function user($username){
		$user = User::where('username','=',$username);
		//if user which username from url is in database
		if($user->count()){
			//pull first user with that username from results(there should be only one anyway)
			$user = $user->first();	

			//pull politicians followed (and later user activity/comments of this user and followers and news)
			$politicians_following = $user->politicians;

			//pull users followed
			$users_following = $user->users;


			$democrat_chart_data =	$this->get_chart_data('Democrat',$user->id);
			$republican_chart_data = $this->get_chart_data('Republican',$user->id);
			$comments = $user->comments;

			return View::make('user')
			       ->with('user',$user)
			       ->with('politicians',$politicians_following)
				->with('democrat_chart_data',$democrat_chart_data)
			       ->with('republican_chart_data',$republican_chart_data)
				->with('comments',$comments)
				->with('title',$user->username."'s Profile")
			       ->with('user_following',$users_following);
		}else return App::abort(404);	
	}
	public function getUsername()
	{
		$user_id = Input::get('user_id');
		return json_encode(array('username'=>User::find($user_id)->first()->username));
	}
	public function getUser()
	{
		$user_id = Input::get('user_id');
		$user = User::find($user_id);
		$username = $user->username;
		$pic_url = $user->pic_url;

		return Response::json(array('username'=>$username,'id'=>$user_id,'pic_url'=>$pic_url));
	}


	public function follow(){
                // creates follow record between logged in user (follower)


		$follow_user_id = Input::get('follow_user_id');
		$user = Auth::user();
                $user_follow = UserFollow::where(function($query) use ($follow_user_id,$user)
                {
                $query->where('following_id', '=',$follow_user_id )
                      ->where('user_id', '=', $user->id);
                });
	       if($user_follow->count())
		{
			//UN-FOLLOW
			$user_follow->delete();
		}
		else
		{
			//FOLLOW
			$user_follow = UserFollow::create(array(
						'following_id'=> $follow_user_id,
						'user_id' => $user->id));
	
		}
	

		//return Redirect::back();



		}


}
?>
