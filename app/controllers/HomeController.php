<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/
	private function reCaptcha()
	{
		require_once('/var/www/html/laravel/app/library/recaptchalib.php');
  		$privatekey = "6LdaP_oSAAAAAE3zyUWf_XpZmVE_Qbbj7ggRIoiC";
  		$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                Input::get("recaptcha_challenge_field"),
                                Input::get("recaptcha_response_field"));
		return array('valid'=>$resp->is_valid,'error'=>$resp->error);
		  
	}

	public function admin()
	{
		if (Auth::user()->isAdmin())
		{	

		return View::make('admin');
		}
		else return App::abort(404);



	}

	public function getContact()
	{
		return View::make('contact')->with('title','Contact Us');
	}

	public function postContact()
	{
		global $captcha;
		$captcha = $this->reCaptcha();

		Validator::extend('recaptcha', function($field, $value, $params)
		{
		    return ($GLOBALS['captcha']['valid']=="true");
		});
		// Build the custom messages array.
		$messages = array("recaptcha" => "reCAPTCHA wasn't entered correctly" 
		);
          	$validator = Validator::make(Input::all(),
				array(
					'email'          =>'required|max:50|email',
					'name'       =>'required',
					'subject'       =>'required',
					'recaptcha_response_field' =>'recaptcha'),
		                      $messages);


		if($validator->fails())
		{
				return Redirect::route('create-get-1')
				->withErrors($validator)
				->withInput();
		}
		else
		{
			$name =  Input::get('name');  // sender
			$email = Input::get('email');
		    	$subject = Input::get('subject');
		    	$message = Input::get('message');
		    	// message lines should not exceed 70 characters (PHP rule), so wrap it
		    	$message = wordwrap($message, 70);
		    	mail("quantumcas@gmail.com",$subject,$message,"From: $email\n");
			return View::make('thanks');
		}

	}

	public function adminlistSearches()
	{
		if (Auth::user()->isAdmin())
		{	
			$searches = DB::table('searches')->orderBy('created_at', 'desc')->paginate(20);
			return  View::make('admin-searches')->with('searches',$searches);
		}
		else return App::abort(404);


	}
	public function searchUrl($search_term)
	{
		
		if (isset($search_term)) 		
			{
				$search_query = '%'.$search_term.'%';			
				$politicians = Politician::where('full_name','like',$search_query)
					->orWhere('party','like',$search_query)
					->orWhere('state','like',$search_query)
					->orWhere('city','like',$search_query)
				        ->orWhere('office','like',$search_query)
					->orWhere('sex','like',$search_query)
					->orWhere('bio','like',$search_query)
					->orWhere('district','like',$search_query)->get();
				
				$users = User::where('username','like',$search_query)
					->orWhere('first_name','like',$search_query)
					->orWhere('last_name','like',$search_query)
					->orWhere('email','like',$search_query)
					->orWhere('party','like',$search_query)
					->orWhere('state','like',$search_query)
					->orWhere('city','like',$search_query)->get();
			
			}

		else {$politicians = null;}

		
		if (isset($search_term)) 		
			{
				$search_query = '%'.$search_term.'%';			
								
				$users = User::where('username','like',$search_query)
					->orWhere('first_name','like',$search_query)
					->orWhere('last_name','like',$search_query)
					->orWhere('email','like',$search_query)
					->orWhere('party','like',$search_query)
					->orWhere('state','like',$search_query)
					->orWhere('city','like',$search_query)->get();
			
			}

		else {$users = null;}
		
		if(isset($search_term))
		{
			$issue = Issue::where('issue_name','=',$search_term)->first();
			
		}
		
		if(isset($search_term))
		{	
			//don't want to repeat same articles in issue and in news. 
			//don't want to do unnescesarry google news calls either
			if($issue==null)
				$news = $this->gNews($search_term);
			else $news = null;
		}
		
		return View::make('results')
				->with('politicians',$politicians)
				->with('news',$news)
				->with('users',$users)
				->with('issue',$issue);



	}

	private function gNews($search_term)
	{
		$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q='".str_replace(' ', '%20', $search_term)."'";

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
			//echo "result :".$resp;
			//array of google search results objects
			$search_results = $result->responseData->results;

		   } catch (Exception $e) 
        		{
		                 echo 'ERROR: ' . $e->getMessage();
		                 exit;
			}

		return $search_results;	
	
	}

	public function article()
	{
		$url =Input::get('url');
		$pic = Input::get('pic');
		$title = Input::get('title');
		$summary = Input::get('summary');
		include "/var/www/html/laravel/app/library/simple_html_dom.php";

		$html = file_get_html($url);
		$content = "";
		
		foreach($html->find('p') as $e) 
    			$content .= '<p class="text-left">'.$e->innertext.'</p>';


		$needle = substr($summary,0, strpos($summary, '.'));
		//$content = strstr($haystack, $needle);

		$fb_og = array('url'=>Request::url() , 'title'=>$title, 'image'=>$pic,
					'description'=>$summary);
		return View::make('article')
			->with('content',$content)
			->with('pic', $pic)->with('url',$url)->with('title',$title)->with('summary',$summary)
			->with('fb_og',$fb_og );
	}
	

	private function mostPopular()
	{

		
		return DB::table('ratings')
                 ->select('politician_id', DB::raw('count(*) as total'))
                 ->groupBy('politician_id')
                 ->get();
	}

	public function home()
	{

			//Tag Cloud
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");

			//create list of issues that have received votes by selecting 
			//rows on first occurance of each unique value
			$query = "select id,issue_id from ratings group by issue_id;";
			$result = mysqli_query($con,$query);
			$issue_tag_cloud = "";
			$i=0;
			//for each id in list of issues, count all the rows in ratings 
			while($row = mysqli_fetch_array($result)) {
				$query = "select id from ratings where issue_id=".$row['issue_id'];
				//echo 'query: '.$query;
			        $result2 = mysqli_query($con,$query);
				$issue_name = Issue::find($row['issue_id'])->issue_name;

				if($issue_name != null)
		                         $issue_tag_cloud .='{text: "'
							  .ucwords($issue_name).'", weight: '
							  .mysqli_num_rows ($result2).' , link: "'
							  .URL::route('news',$issue_name).'"},'."\n";



				

				}//close while
				//remove trailing new line and trailing comma so tag cloud js will work
				$issue_tag_cloud = substr_replace($issue_tag_cloud ,"",-1);
				$issue_tag_cloud = substr_replace($issue_tag_cloud ,"",-1);
		//Comment Feed: Take top 3 highest ranked comments
		$comments = DB::table('comments')
		    ->where('politician_id','>',0)//some comments don't have politicians..this ensures we only select comments that do
                    ->orderBy('rank', 'desc')
		    ->orderBy('created_at', 'desc')
                    ->take(3)->get();

		//News Feed: Take last 3 news for now
		$news = DB::table('news')->take(3)->get();
               $comments_array = array();
	       $news_array = array();
		$i=0;
		foreach ($comments as $comment)
			$comment_array[$i++] = array(
				'user_id'=> $comment->user_id,
				'politician_id' => $comment->politician_id,
				'created_at' 	=> $comment->created_at,
				'content' 	=> $comment->content,
				'id'		=> $comment->id);
		$i=0;
		foreach ($news as $article)
			$news_array[$i++] =  array(
				'id'		=> $article->id,
				'headline'	=> $article->headline,
				'source'	=> $article->source,
				'content' 	=> $article->content,
				'feature_pic_url'=>$article->feature_pic_url);

			
	
                   
 
		return View::make('main')
		->with('comments',$comment_array)
		->with('news',$news_array)
		->with('most_popular_politicians',$this->mostPopular())
		->with('issue_tag_cloud',$issue_tag_cloud);
	}

	public function news($issue_name)
	{
	
	$issue = Issue::where('issue_name','=',$issue_name)->first();
	$news = $issue->gNews();
	return View::make('news')->with('news',$news)->with('issue_name',$issue_name);

	}

	public function about()
	{

		 return View::make('about')->with('title','About Us');
	}

	public function search()
	{
		$search_term = Input::get('search_term'); 

		if ((isset($search_term)) && ($search_term != ''))		
			{


				$search_query = '%'.$search_term.'%';			
				$politicians = Politician::where('full_name','like',$search_query)
					->orWhere('party','like',$search_query)
					->orWhere('state','like',$search_query)
					->orWhere('city','like',$search_query)
				        ->orWhere('office','like',$search_query)
					->orWhere('sex','like',$search_query)
					->orWhere('bio','like',$search_query)
					->orWhere('district','like',$search_query)->get();
	
				if ($politicians->count()==0)
					$politicians=null;
				
				$users = User::where('username','like',$search_query)
					->orWhere('first_name','like',$search_query)
					->orWhere('last_name','like',$search_query)
					->orWhere('email','like',$search_query)
					->orWhere('party','like',$search_query)
					->orWhere('state','like',$search_query)
					->orWhere('city','like',$search_query)->get();

				if ($users->count()==0)
					$users=null;
			
				$issue = Issue::where('issue_name','=',$search_term)->first();
				
		
				//don't want to repeat same articles in issue and in news. 
				//don't want to do unnescesarry google news calls either
				//either news or issues
				if($issue==null)
					$news = $this->gNews($search_term);
				else $news = null;

				
				$found = (!(($issue==null)&&($politicians==null)&&($news==null)&&($users==null)));
				$user_id = ((Auth::check()) ? Auth::user()->id : 0); 

				//we're saving search attempts for study later. who searches and wether results are given.
				$search = Search::create(array('search_term'=>$search_term,'found'=>$found,'user_id'=>$user_id));
			        $search->save();
		} else {$politicians=null;$issue=null;$news = null;$users = null;}
		return View::make('results')
				->with('politicians',$politicians)
				->with('news',$news)
				->with('users',$users)
				->with('issue',$issue);
	}

		
	

}
