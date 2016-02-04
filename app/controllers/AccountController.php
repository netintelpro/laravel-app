<?php
class AccountController extends BaseController{

private function gen_random_string($length=16)
{
    $chars ="ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";//length:36
    $final_rand='';
    for($i=0;$i<$length; $i++)
    {
        $final_rand .= $chars[ rand(0,strlen($chars)-1)];
 
    }
    return $final_rand;
}
	
public function test()
{
		
		return View::make('test');


}

public function getSignOut()
{
			
	$user = Auth::user();
	$user->last_logout_at = new DateTime('now');
	$user->save();			
	Auth::logout();
	return View::make('login')->with('fb_sign_out',true);
}

public function getLogin()// Displays form user needs to login
{
	return View::make('login')->with('fb_sign_out',false)->with('title','Log In');
}	

public function fbConnect()
{
	if(!(Auth::check()))
		{
			$fb_user = Input::get('fb_user');

			$user = User::where('email','=',$fb_user['email'])->first();
			if ($user != null)
			{
				if ($user->count())
					{
			
						Auth::login($user);
						$user->last_login_at =  new DateTime('now');
						$user->last_ip_address = $_SERVER["REMOTE_ADDR"];
						$user->save();
						return Response::json(array('status'=>'logging'));
					}
				else 	
					{
						//create user account
						$user = User::create(array(
							'email' => 'test@test.com',//$fb_user['email'],
							'username' => 'Monkey', //$fb_user['name'],
							'password' => Hash::make($this->gen_random_string(12)),
							'code' => str_random(60), //Activation code
							'active' => 1 ));//normally active = 0 but until we can get email validation working it will stay 1);
						$user->save();
						Auth::login($user);
						return Response::json(array('status'=>'registering'));
					}
			}

			else 
				{

						$fb_user_name = explode(" ", $fb_user['name']);
						//create user account
						$user = User::create(array(
							'email' => $fb_user['email'],
							'username' => $fb_user['name'],
							'password' => Hash::make($this->gen_random_string(12)),
							'first_name'=> $fb_user_name[0],
							'last_name'=> $fb_user_name[1],
							'code' => str_random(60), //Activation code
							'active' => 1 ));//normally active = 0 but until we can get email validation working it will stay 1);
						$user->save();
						Auth::login($user);
						
						return Response::json(array('status'=>'registering'));
					}
		}
	else 	
		return Response::json(array('status'=>'logged'));		
}		
	
	
	public function postLogin()
	{
       
		$validator = Validator::make(Input::all(),
			array(
				'email'          =>'required|email',
				'password'       =>'required'
                             ));
		if($validator->fails()){

			return Redirect::route('login')
			->withErrors($validator)
			->withInput();
		}
        	else{
			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
				));

	
			if ($auth){
			$user = Auth::user();
			$user->last_login_at =  new DateTime('now');
			$user->last_ip_address = $_SERVER["REMOTE_ADDR"];
			$user->save();
			//Redirect to the intended page
			return Redirect::intended('/');

			}else{

			return Redirect::route('login')
				->with('global','Email/password wrong, or account not activated');
                     }
			
		}// ($validator->fails())
		/*return Redirect::route('login')
			->with('global','There was a problem signing you in.');*/
			
	}//postLogin()

	public function getCreate()
	{
		$issues = Issue::all();
		return View::make('create')
		->with('issues',$issues);
	}
	public function getCreate2()
	{
		$issues = Issue::all();
		return View::make('create-2')
		->with('issues',$issues)->with('title','Sign Up Part 2');
	}
	

	public function getCreate1()
	{
		return View::make('create-1')->with('captcha_error',null)->with('title','Sign Up');
	}

	public function postCreate2()
	{
			$user = Auth::user();
			$user->sex = Input::get('sex');
			$user->birth_month = Input::get('birth_month');
			$user->birth_day = Input::get('birth_day');
			$user->birth_year = Input::get('birth_year');
			$user->party = Input::get('party');
			$user->bio = Input::get('bio');
			$user->username = Input::get('username');

			//Upload Image
			$file = Input::file('photo');
			$validator = Validator::make(Input::all(),array('photo'=>'image'));
			if($validator->fails())
			{		
				return Redirect::route('create-post-2')
				->withErrors($validator)
				->withInput();
			}
        		else{
		   		if (isset($file))
				{
			               if ($file->isValid())
					{
						$destinationPath    = public_path().'/assets/images/avatars/'; // The destination were you store the image.
						$filename = $file->getClientOriginalName();
		    			        $file->move($destinationPath, $filename);
						$user->pic_url = '/assets/images/avatars/'.$filename;
					}
				}
			
				$user->save();
	
	  		         
				$issues = Issue::all();
				foreach($issues as $issue)
				{
					$issue_checkbox = Input::get($issue->id);
					if (isset($issue_checkbox))
					{
						$issues_follows = IssueFollow::create(array('issue_id'=> $issue_checkbox,'user_id' => $user->id));
						$issues_follows->save();	
					}
				}
				$auto_politician = Input::get('auto-politician');
				$rant = Input::get('rant');
				if ((isset($auto_politician))&&(isset($rant)))
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
		
				//Redirect to login page - added to redirect to home upon successful account 

				return Redirect::route('myprofile');
			}
	}

	

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
	

        public function postCreate1()
	{
	
		/* https://developers.google.com/recaptcha/docs/php */
		/* http://daylerees.com/codebright/validation ;*/

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
					'email'          =>'required|max:50|email|unique:users',
					'username'       =>'required|max:20|min:3|unique:users',
					'password'       =>'required|min:6',
					'password_again' =>'required|same:password',
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
				//create user account
				$user = User::create(array(
					'email' => Input::get('email'),
					'username' => Input::get('username'),
					'password' => Hash::make(Input::get('password')),
					'code' => str_random(60), //Activation code
					'active' => 1 ));//normally active = 0 but until we can get email validation working it will stay 1);
				$user->save();
				$auth = Auth::attempt(array(
					'email' => Input::get('email'),
					'password' => Input::get('password'),
					'active' => 1
					));
				$auto_politician = Input::get('auto-politician');
				$rant = Input::get('rant');
				if ((isset($auto_politician))&&(isset($rant)))
					{
						$issues = Issue::all();
						return View::make('create-2')
							->with('issues',$issues)
							->with('rant_data', array('auto-politician'=>$auto_politician,'rant'=> $rant));

					}
				else return Redirect::action('AccountController@getCreate2');

		}	
	}


	public function postCreate()
	// Called when user submits create account form
	{
          
      
	$validator = Validator::make(Input::all(),
			array(
				'email'          =>'required|max:50|email|unique:users',
				'username'       =>'required|max:20|min:3|unique:users',
				'password'       =>'required|min:6',
				'password_again' =>'required|same:password'
                             ));

	
	if($validator->fails())
	{
			return Redirect::route('create')
			>withErrors($validator)
			->withInput();
	}
        else
	{
			//create user account
			$user = User::create(array(
				'email' => Input::get('email'),
				'username' => Input::get('username'),
				'password' => Hash::make(Input::get('password')),
				'code' => str_random(60), //Activation code
				'active' => 1 ));//normally active = 0 but until we can get email validation working it will stay 1);
			$user->save();



			$user->sex = Input::get('sex');
			$user->birth_month = Input::get('birth_month');
			$user->birth_day = Input::get('birth_day');
			$user->birth_year = Input::get('birth_year');
			$user->party = Input::get('party');
			$user->bio = Input::get('bio');

			
			//Upload Image


			$file = Input::file('photo');
           		if (isset($file))
			{
	                       if ($file->isValid())
				{
					$destinationPath    = public_path().'/assets/images/avatars/'; // The destination were you store the image.
					$filename = $file->getClientOriginalName();
	    			        $file->move($destinationPath, $filename);
					$user->pic_url = '/assets/images/avatars/'.$filename;
				}
			}
			
			$user->save();
	
  		       /* $filename           = $file->getClientOriginalName(); // Original file name that the end user used for it.
  			 $mime_type          = $file->getMimeType(); // Gets this example image/png
 			 $extension          = $file->getClientOriginalExtension(); // The original extension that the user used example .jpg or .png.
  			try{ $upload_success     = $file->move($destinationPath, $filename); // Now we move the file to its new home.
 			} catch (Exception $e) {return 'Caught exception image upload: '.$e->getMessage();}
                        */
   			// This is were you would store the image path in a table
    
			$issues = Issue::all();
			foreach($issues as $issue)
			{
				$issue_checkbox = Input::get($issue->id);
				if (isset($issue_checkbox))
				{
					$issues_follows = IssueFollow::create(array('issue_id'=> $issue_checkbox,'user_id' => $user->id));
					$issues_follows->save();	
				}
			}
		
			//Redirect to login page - added to redirect to home upon successful account 

			$auth = Auth::attempt(array(
				'email' => Input::get('email'),
				'password' => Input::get('password'),
				'active' => 1
				));
			return Redirect::route('myprofile');
	}// else

	/*
	if ($user){
        
	//send email here
		Mail::send(/*'emails.activate',*//*'activate',
		array('link' =>URL::route('activate',$code), 'username'=>$username),function($message) use ($user){
	       return $message->to($user->email,$user->username)->subject('Activate your account');
		});
			
				return Redirect::route('home')
				->with('global','Your account has been created! We have sent you an email to activate your account');
			
		  
           }*/  //if ($user)
	

                    
	}//end function postCreate()

	public function getActivate($code)
	{
		try{
				return 'Activate';
		    }	
		catch (Exception $e) {return 'Caught exception in getActivate($code) AccountController.php: '.$e->getMessage();}
		/*
		$user = User::where('code','=',$code)->where('active','=',0);	
                if($user->count()){
                $user = $user->first();
                //Update user to active state
 		$user->active = 1;
		$user->code   ='';
		if($user->save()){
			return Redirect::route('home')
				->with('global','Activated! You can now sign in!');
		}
		}
		return Redirect::route('home')
			->with('global','We could not activate your account try again later.');
		echo '<pre>',print_r($user),'</pre>';

	*/}
}//end class AccountController
