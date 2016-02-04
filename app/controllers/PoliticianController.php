<?php
class PoliticianController extends BaseController{


	public function autoPolitician()
	{
		$term = Input::get('term');
		$search_query = '%'.$term.'%';			
		$politicians = Politician::where('full_name','like',$search_query)->get();
		$result = $politicians->lists('full_name');
		return Response::json($result);

	}




	public function getSubmitPolitician()
	{
		return View::make('submit-politician')->with('title','Submit A Politician');
		
	}

	public function postSubmitPolitician()
	{
		

		$validator = Validator::make(Input::all(),
				array(
					'full_name'          =>'required|unique:politicians',
					'last_name'       =>'required',
					'last_name'       =>'required',
					'office' =>'required',
					'district'=> 'required',
						'party'=> 'required',
						'city'=> 'required',
						'bio'=> 'required',
						'state'=> 'required',
					'sex' =>'required'));
			


		if($validator->fails())
		{
				return Redirect::route('submit-politician')
				->withErrors($validator)
				->withInput();
		}
		else
		{	
		//$bw_pic_url = " ";//$this->greyScale($pic_url);

		$politician = Politician::create(array(
						'full_name'=> Input::get('full_name'),
						'first_name'=> Input::get('first_name'),
						'last_name'=> Input::get('last_name'),
						'office'=> Input::get('office'),
						'district'=> Input::get('district'),
						'party'=> Input::get('party'),
						'city'=> Input::get('city'),
						'bio'=> Input::get('bio'),
						'state'=> Input::get('state'),
						'created_by'=> Auth::user()->id,
						'sex'=> Input::get('sex'),
						'approved' =>'no'

						/*'bw_pic_url' => $bw_pic_url */));


               $pic_url = $this->uploadImage(Input::get('full_name'));
			//only want to replace pic url if there is something uploaded in edit form
			if ($pic_url != null)
				$politician->pic_url = $pic_url;


               

		$politician->save();
		//notify admin via email that politician has been submitted
		$subject = 'Politician Submitted';
		$message = '<html><body>Politician <a href="'.URL::route('edit-politician', $politician->full_name).'" >'.$politician->full_name
		.'</a> has been created by user '
		.'<a href="'.URL::route('profile-user',Auth::user()->username).'" >'
		.Auth::user()->username.'</a> and awaits admin approval. You may visit record <a href="'
		.URL::route('edit-politician', $politician->full_name).'" >here.</a></body></html>';
		$users = User::where('role','=','admin')->get();
		$email = 'contact@iratepolitics.com';

		$headers='MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
		$headers .= "From: $email\n";
		foreach ($users as $user)
			mail($user->email,$subject,$message,$headers);

		return View::make('thanks');
		}
	}

	public function test()
	{

	
 
    		mail("quantumcas@gmail.com","Test","Test","From: Test");


	 	return View::make('test');
	


	}	



	public function listCandidates()
	{

		if (Auth::user()->isAdmin())
	
			return  View::make('candidates');
	
		else return App::abort(404);
	}

		
	

	
	private function getPoliticianNews($politician_name, $issue_name)
		{
		

		$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=".$politician_name."+".$issue_name;




		try{
			$curl= curl_init();
			curl_setopt_array($curl, array(
         	   	CURLOPT_RETURNTRANSFER => 1,
    	 		CURLOPT_URL => $URL_CURLOPT

			));
			// Send the request & save response to $resp
			$resp = curl_exec($curl);
			// Close request to clear up some resources
			curl_close($curl);
		        $result = json_decode($resp);

			//array of google search results objects
			$search_results = $result->responseData->results;

		   } catch (Exception $e) {
                 echo 'ERROR: ' . $e->getMessage();
                 exit;}

		return $search_results;
		}

	private function generatePoliticianChart($politician_id)
	{
			//make list of all ids
			$democrat_ratings = array();
			$republican_ratings = array();

			//Hate to throw tacky direct php mysql queries instead of ORM. But having trouble with
			//ORM query logic for inner joins of derived tables. Need beta now and will ORM later.
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");
                        

			//Democrat Ratings: Get value and timestamp of all democrat users' ratings for this politician
                        $query = "select value,r.created_at from (select * from ratings where politician_id='".$politician_id."') as r inner join (select * from users where party='Democrat') as u on r.user_id = u.id";
			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $democrat_ratings[$i++] = array(
					'value'=>$row['value'],
					'created_at' => $row['created_at']
				);
 				 
				}//close while
			//Republican Ratings: Get value and timestamp of all republican users' ratings for this politician			
			$query = "select value,r.created_at from (select * from ratings where politician_id='".$politician_id."') as r inner join (select * from users where party='Republican') as u on r.user_id = u.id";
			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $republican_ratings[$i++] = array(
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


			$democrat_chart_data = array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0);			
			foreach ($democrat_ratings as $rating) {
				$rate = array();
				$rating_date = new DateTime($rating['created_at']); //echo ' Rating Date: '.$rating_date->format("Y-m-d H:i:s");
				
				$date_interval = $todays_date->diff($rating_date);//echo ' $date_interval: '.$date_interval->format("%a")."days\n";
			        $date_interval = intval($date_interval->format("%a"));			        
				if ($date_interval <=6) 
				{
					$democrat_chart_data[6-$date_interval] += $rating['value'];
				}

			}


			$republican_chart_data = array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0);

			foreach ($republican_ratings as $rating) {
				$rate = array();
				$rating_date = new DateTime($rating['created_at']); //echo ' Rating Date: '.$rating_date->format("Y-m-d H:i:s");
				
				$date_interval = $todays_date->diff($rating_date);//echo ' $date_interval: '.$date_interval->format("%a")."days\n";
			        $date_interval = intval($date_interval->format("%a"));
				if  ($date_interval<=6) 
				{
					$republican_chart_data[6-$date_interval] += $rating['value'];
				}

			}
			return array(
				'democrat_chart_data' => $democrat_chart_data,
				'republican_chart_data' => $republican_chart_data,
	                        'trend' =>Politician::find($politician_id)->ratings->sum('value')
					);
			



	}
	

	public function createPolitician()
	{
	if (Auth::user()->isAdmin())
	{
		return View::make('create-politician');
	}
		else return App::abort(404);
	}

        private function greyScale($image)
	{

		/*http://php.about.com/od/gdlibrary/ss/grayscale_gd.htm#step-heading
		$image_substring = substr($image, 0, strpos($image ,'.'));//strip image name before filetype
		/*$im = imagecreatefromjpeg(public_path().$image_substring.'-bw.jpg');

		imagefilter($im, IMG_FILTER_GRAYSCALE);
		return $im;
		
		//Reads the origonal colors pixel by pixel 

		$image_size = getimagesize(public_path().$image); 
		for ($y=0;$y<$image_size['height'];$y++)  
			{ for ($x=0;$x<$image_size['width'];$x++)  
				{ 
					$rgb = imagecolorat(public_path().$image,$x,$y); 
					$r = ($rgb >> 16) & 0xFF; 
					$g = ($rgb >> 8) & 0xFF; 
					$b = $rgb & 0xFF;  
					//This is where we actually use yiq to modify our rbg values, 
					//and then convert them to our grayscale palette 
					$gs = yiq($r,$g,$b); imagesetpixel($bwimage,$x,$y,$palette[$gs]); 
				} 
			}   
		// Outputs a jpg image
		imagejpeg($bwimage);
		
*/

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
						$destinationPath    = public_path().'/assets/images/politicians/'; // The destination were you store the image.
						$filename = trim(str_replace(' ','',$last_name)).'.jpg';//$file->getClientOriginalName();
		    			        $file->move($destinationPath, $filename);
						$pic_url = '/assets/images/politicians/'.$filename;
					}
				}
					
			return $pic_url;
		} else{ return null;}
	
	}

	public function deletePolitician()
	{
		//dont forget to delete image file...look up  ^ for file save code

		if (Auth::user()->isAdmin())
		{
		
		

			$politician_id = Input::get('politician_id');
			$politician = Politician::find($politician_id);
		/*	if (file_exists(public_path().$politician->pic_url)) 
			{
	    				unlink(public_path().$politician->pic_url); // Delete now
			}
	
		*/	$politician->delete();
			return Redirect::action('PoliticianController@adminlistPoliticians');	
		}
		else return App::abort(404);

	}

	public function newPolitician()
	{
		
			
		//$bw_pic_url = " ";//$this->greyScale($pic_url);

		$politician = Politician::create(array(
						'full_name'=> Input::get('full_name'),
						'first_name'=> Input::get('first_name'),
						'last_name'=> Input::get('last_name'),
						'office'=> Input::get('office'),
						'district'=> Input::get('district'),
						'party'=> Input::get('party'),
						'city'=> Input::get('city'),
						'bio'=> Input::get('bio'),
						'state'=> Input::get('state'),
						'created_by'=> Auth::user()->id,
						'sex'=> Input::get('sex'),

						/*'bw_pic_url' => $bw_pic_url */));


               $pic_url = $this->uploadImage(Input::get('full_name'));
			//only want to replace pic url if there is something uploaded in edit form
			if ($pic_url != null)
				$politician->pic_url = $pic_url;


               

		$politician->save();


		//return View::make('create_politician');
		return Redirect::action('PoliticianController@adminlistPoliticians');
	}

	public function editPolitician($fullname)
	{

		if (Auth::user()->isAdmin())
		{
			$politician = Politician::where('full_name','like',$fullname)->first();

			if ($politician != null)
				return View::make('edit-politician')->with('politician',$politician);
			else return Redirect::action('PoliticianController@adminlistPoliticians');	
		}
		else return App::abort(404);


	}
	
	public function updatePolitician()
	{
		if (Auth::user()->isAdmin())
		{
			
			$politician = Politician::find(Input::get('politician_id'));
			$pic_url = $this->uploadImage(Input::get('last_name'));
			//only want to replace pic url if there is something uploaded in edit form
			if ($pic_url != null)
				$politician->pic_url = $pic_url;

			
			$politician->full_name = Input::get('first_name')." ".Input::get('last_name');
			$politician->first_name = Input::get('first_name');
			$politician->last_name = Input::get('last_name');
			$politician->office = Input::get('office');
			$politician->district = Input::get('district');
			$politician->bio = Input::get('bio');
			$politician->city = Input::get('city');
			$politician->state = Input::get('state');
			$politician->sex = Input::get('sex');
			$politician->party = Input::get('party');
			$politician->approved = Input::get('approved');

			//$politician->bw_pic_url = " ";//$this->greyScale($politician->pic_url);
			$politician->save();
			//return Redirect::action('PoliticianController@adminlistPoliticians');

			return Redirect::back();
		}
		else return App::abort(404);
	}
	private function issuesNotFollowed($user_id)
	{
			$issues_already_followed = array();
			$issues_not_followed = array();
			$i = 0;
			foreach(User::find($user_id)->issues as $issue_followed)
				$issues_already_followed[$i++] = $issue_followed->id;
			$i = 0;
			foreach(Issue::all() as $issue)
				if(!(in_array($issue->id,$issues_already_followed)))//if issue is already being followed
					$issues_not_followed[$i++] = $issue->id;
			if (count($issues_not_followed)>0)
				return DB::table('issues')->whereIn('id',$issues_not_followed)->get();
			else return null;
			
	}

	public function profilePolitician($fullname){

		//gets politician record by fullname
		$politician = Politician::where('full_name','=',$fullname);

		if($politician->count()){

			//shows only issues logged in user follows
			if(Auth::check())
				$issues      = User::find(Auth::user()->id)->issues;
			else $issues = null;

			//gets specific politician entity/record
			$politician = $politician->first();

			//make list of all ids
			$democrat_ratings = array();
			$republican_ratings = array();

			//Hate to throw tacky direct php mysql queries instead of ORM. But having trouble with
			//ORM query logic for inner joins of derived tables. Need beta now and will ORM later.
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");
                        

			//Democrat Ratings: Get value and timestamp of all democrat users' ratings for this politician
                        $query = "select value,r.created_at from (select * from ratings where politician_id='".$politician->id."') as r inner join (select * from users where party='Democrat') as u on r.user_id = u.id";
			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $democrat_ratings[$i++] = array(
					'value'=>$row['value'],
					'created_at' => $row['created_at']
				);
 				 
				}//close while
			//Republican Ratings: Get value and timestamp of all republican users' ratings for this politician			
			$query = "select value,r.created_at from (select * from ratings where politician_id='".$politician->id."') as r inner join (select * from users where party='Republican') as u on r.user_id = u.id";
			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $republican_ratings[$i++] = array(
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


			$democrat_chart_data = array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0);			
			foreach ($democrat_ratings as $rating) {
				$rate = array();
				$rating_date = new DateTime($rating['created_at']); //echo ' Rating Date: '.$rating_date->format("Y-m-d H:i:s");
				
				$date_interval = $todays_date->diff($rating_date);//echo ' $date_interval: '.$date_interval->format("%a")."days\n";
			        $date_interval = intval($date_interval->format("%a"));			        
				if ($date_interval <=6) 
				{
					$democrat_chart_data[6-$date_interval] += $rating['value'];
				}

			}


			$republican_chart_data = array("0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0);

			foreach ($republican_ratings as $rating) {
				$rate = array();
				$rating_date = new DateTime($rating['created_at']); //echo ' Rating Date: '.$rating_date->format("Y-m-d H:i:s");
				
				$date_interval = $todays_date->diff($rating_date);//echo ' $date_interval: '.$date_interval->format("%a")."days\n";
			        $date_interval = intval($date_interval->format("%a"));
				if  ($date_interval<=6) 
				{
					$republican_chart_data[6-$date_interval] += $rating['value'];
				}

			}
			//Issue Tag Cloud

					
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");

			//create list of issues for which politician has received votes by selecting 
			//rows on first occurance of each unique value
			$query = "select id,issue_id from ratings where politician_id=".$politician->id." group by issue_id;";
			$result = mysqli_query($con,$query);
			$issue_tag_cloud = "";
			$i=0;
			//for each id in list of issues, count all the rows in ratings where a vote was made for that politician & that issue
			//this is a count of 'activity' for each issue per politican. (ex. votes on Pelosi's stance on Obamacare)
			while($row = mysqli_fetch_array($result)) {
				$query = "select id from ratings where issue_id=".$row['issue_id']." and politician_id=".$politician->id;
				//echo 'query: '.$query;
			        $result2 = mysqli_query($con,$query);
				$issue_name = Issue::find($row['issue_id'])->issue_name;

				



				$issue_tag_cloud .='{text: "'
						  .ucwords($issue_name).'", weight: '
						  .mysqli_num_rows ($result2).' , link: "'
						  .URL::route('news',$issue_name).'"},'."\n";
				

				}//close while
				//remove trailing new line and trailing comma so tag cloud js will work
				$issue_tag_cloud = substr_replace($issue_tag_cloud ,"",-1);
				$issue_tag_cloud = substr_replace($issue_tag_cloud ,"",-1);

			//Display Comments...only comments with no parents
			$comments = $politician->comments()->where('parent_id', '=', '0')->orderBy('rank', 'desc')->orderBy('created_at', 'desc')->get();	
			
			//$comments = Comment::where('politician_id','=',$politician->id)->where('parent_id', '=', '0')->get();		
			if(Auth::check())
				$issues_not_followed = $this->issuesNotFollowed(Auth::user()->id);

			else $issues_not_followed = Issue::all();
			
			$fb_og = array('url'=>Request::url() , 'title'=>$politician->full_name, 'image'=>$_SERVER['SERVER_NAME'].$politician->pic_url,
					'description'=>$politician->bio);




			return View::make('politician')
			       ->with('politician',$politician)
			       ->with('issues',$issues)
			       ->with('comments',$comments)
			       ->with('democrat_chart_data',$democrat_chart_data)
			       ->with('republican_chart_data',$republican_chart_data)
				->with('issue_tag_cloud',$issue_tag_cloud)
				->with('issues_not_followed',$issues_not_followed)
				->with('fb_og',$fb_og )
				->with('title',$politician->full_name."'s Profile");
		
		}else return App::abort(404);//if politician not found in database then page not found error returned.	

	}
	public function listPoliticians(){
	//list politicians in order of most voting activity
        

	 // This method will return an array of politician ids. 
	 $list = DB::table('ratings')
                 ->select('politician_id', DB::raw('count(*) as total'))
                 ->groupBy('politician_id')->orderBy('total')->lists('politician_id');



         //This returns records whose ids are within array...paginated
		$politicians = DB::table('politicians')
                    ->whereIn('id',$list)->paginate(4);

		return View::make('politicians')
			  ->with('politicians',$politicians)->with('title','Politicians');
	}

	public function mostPopular()
	{
	//list politicians in order of sum of value of votes or highest ranking

      		$politicians = DB::table('politicians')->orderBy('rank', 'desc')->paginate(10);
		
		return View::make('most-popular')
			->with('politicians',$politicians)->with('title','Most Popular Politicians');



	}

	public function leastPopular()
	{
	//list politicians in order of sum of value of votes or highest ranking

      		$politicians = DB::table('politicians')->orderBy('rank', 'asc')->paginate(10);
		
		return View::make('most-popular')
			->with('politicians',$politicians)->with('title','Least Popular Politicians');



	}

	public function adminlistPoliticians()
	{

		$page = Input::get('page');
		if (Auth::user()->isAdmin())
		{
			
			
			Politician::resolveConnection()->getPaginator()->setCurrentPage($page);
			//Order last created first, so its more convenient to delete mistakes made on recently created politicians
			$politicians = DB::table('politicians')->orderBy('id', 'desc')->paginate(30);


			return  View::make('admin-politicians')->with('politicians',$politicians)->with('page',$page);
		}
		else return App::abort(404);
	}

	

	public function issueVote(){
		$politician_id = Input::get('politician_id');
		$issue_id = Input::get('issue_id');
		$user_id = Auth::user()->id;
		$vote_value = Input::get('vote');
		$new_rating_array = array(
						'politician_id'=> $politician_id,
						'user_id' => $user_id,
						'issue_id'=> $issue_id,
						'value'   => $vote_value);
		$rating = Rating::create($new_rating_array);
		
		//adjust politician rank
		$politician = Politician::find($politician_id);
		$politician->rank += $vote_value;
		$politician->save();
                
		$title = $politician->full_name."'s Approval Over Last 7 Days";
		$chartController = new ChartController();

		$response = $chartController->generatePoliticianChart($politician_id,$title);

		return Response::json($response);
	//	return Response::json($new_rating_array);



	}    


	
	public function follow(){
                // get politician id from fullname
		// get user id from user name 
		//create poltiican record from user id, politician id


		$politician_id = Input::get('politician_id');
		$politician = Politician::where('id','=',$politician_id);
		$user = Auth::user();
                $politician_follow = PoliticianFollow::where(function($query) use ($politician)
                {
                $query->where('politician_id', '=',Input::get('politician_id') )
                      ->where('user_id', '=', Auth::user()->id);
                });
	       if($politician_follow->count())
		{
			//UN-FOLLOW
			$politician_follow->delete();
		}
		else
		{
			//FOLLOW
			$politician_follow = PoliticianFollow::create(array(
						'politician_id'=> $politician_id,
						'user_id' => $user->id));
	
		}
	

		//return Redirect::back();



		}

					

}//PoliticianController
?>
