<?php
Route::get('/politicians/{fullname}', array(
		'as' =>	'profile-politician',
	'uses' => 'PoliticianController@profilePolitician'
	));

Route::post('rant',array(
			'as'=> 'rant',
			'uses'=> 'CommentController@rantSubmit'
	));
	Route::get('politicians', array(
	'as' =>	'list-politicians',
	'uses' => 'PoliticianController@listPoliticians'
	));
	Route::get('article', array(
		'as' =>'article',
		'uses'=>'HomeController@article'
		));	


	Route::get('/', array(
	    'as' => 'home',
	    'uses' => 'HomeController@home'
	));
	
	Route::get('/search/{search_term}', array(
		'as' =>'search-url',
		'uses'=>'HomeController@searchUrl'
	));
Route::get('contact', array(
		'as' => 'contact',
		'uses' => 'HomeController@getContact'

	));

Route::post('contact', array(
		'as' => 'contact',
		'uses' => 'HomeController@postContact'

	));

Route::post('auto-politician', array(
		'as' => 'auto-politician',
		'uses' => 'PoliticianController@autoPolitician'

	));


	Route::get('about', array(
		'as' => 'about',
		'uses' => 'HomeController@about'

	));

	Route::get('test', array(
		'as' => 'test',
		'uses' => 'AccountController@test'

	));

	Route::get('test2', function()
	{
	return Response::view('test2');
	});



	Route::post('test', array(
	
		'as' => 'test',
		'uses' => 'PoliticianController@test'
	));


	Route::post('fb-connect',array(
    			'as' => 'fb-connect',
    			'uses' => 'AccountController@fbConnect'
		));

	Route::post('issue-vote',array(
    			'as' => 'issue-vote',
    			'uses' => 'PoliticianController@issueVote'
		));
	Route::post('get-news',array(
			'as' =>'get-news',
			'uses' => 'IssueController@getNews'
		));

	Route::post('search', array(
		'as' =>'search',
		'uses'=>'HomeController@search'
	));

	Route::get('most-popular', array(
		'as' =>'most-popular',
		'uses'=>'PoliticianController@mostPopular'
	));
	Route::get('least-popular', array(
		'as' =>'least-popular',
		'uses'=>'PoliticianController@leastPopular'
	));


	Route::get('/news/{issue_name}', array(
			'as' => 'news',
			'uses' => 'HomeController@news'
		));

/*********************Charts***********************************/
	Route::post('question-chart', array(
			'as' => 'question-chart',
			'uses' => 'ChartController@getQuestionChart'
		));
	

	Route::post('user-chart', array(
			'as' => 'user-chart',
			'uses' => 'ChartController@getUserChart'
		));
	

	Route::post('politician-chart', array(
			'as' => 'politician-chart',
			'uses' => 'ChartController@getPoliticianChart'
		));

	Route::post('chart-range', array(
			'as' => 'chart-range',
			'uses' => 'ChartController@chartRange'
		));


	

/*
|  Authenticated group
*/
Route::group(array('before' => 'auth'), function(){





Route::post('create-2',array(
			'as' => 'create-post-2',
			'uses' => 'AccountController@postCreate2'
		));

Route::get('create-2',array(
			'as' => 'create-get-2',
			'uses' => 'AccountController@getCreate2'
		));
/**************************************************************/

Route::get('admin', array(
			'as' => 'admin',
			'uses' => 'HomeController@admin'
		));


Route::get('admin/poll/edit/{title}', array(
			'as' => 'edit-poll',
			'uses' => 'PollController@editPoll'
		));
	
Route::post('admin/poll/edit/{title}', array(
			'as' => 'edit-poll',
			'uses' => 'PollController@updatePoll'
		));

Route::get('/admin/polls/', array(
			'as' => 'admin-polls',
			'uses' => 'PollController@adminlistPolls'
		));

Route::post('new-poll', array(
			'as' => 'new-poll',
			'uses'=> 'PollController@newPoll'
		));

Route::post('delete-poll', array(
			'as' => 'delete-poll',
			'uses' => 'PollController@deletePoll'
		));

Route::post('delete-comment', array(
			'as' => 'delete-comment',
			'uses' => 'CommentController@deleteComment'
		));

Route::post('delete-question', array(
			'as' => 'delete-question',
			'uses' => 'PollController@deleteQuestion'
		));

Route::post('delete-answer', array(
			'as' => 'delete-answer',
			'uses' => 'PollController@deleteAnswer'
		));

Route::get('/poll/question/{id}', array(
			'as' => 'question',
			'uses' => 'PollController@getQuestion'
		));

Route::post('/poll/question/{id}', array(
			'as' => 'question',
			'uses' => 'PollController@submitQuestion'
		));
/********************Issues***********************************/	
	Route::post('delete-issue', array(
			'as' => 'delete-issue',
			'uses' => 'IssueController@deleteIssue'
		));
	
	


	Route::post('new-issue', array(
			'as' => 'new-issue',
			'uses'=> 'IssueController@newIssue'
		));

	Route::post('update-issue', array(
			'as' => 'update-issue',
			'uses'=> 'IssueController@updateIssue'
		));	
	

	Route::get('/admin/searches/', array(
			'as' => 'admin-searches',
			'uses' => 'HomeController@adminlistSearches'
		));

	Route::get('/admin/issues/', array(
			'as' => 'admin-issues',
			'uses' => 'IssueController@adminlistIssues'
		));

	Route::get('issue/edit/{issuename}', array(
			'as' => 'edit-issue',
			'uses' => 'IssueController@editIssue'
		));
	
	Route::post('issue/edit/{username}', array(
			'as' => 'edit-issue',
			'uses' => 'IssueController@updateIssue'
		));

	Route::get('create-issue', array(
			'as' => 'create-issue',
			'uses' => 'IssueController@createIssue'
		));

	
		

		
	

/***************************Politicians**************************************/



	Route::post('delete-politician', array(
			'as' => 'delete-politician',
			'uses' => 'PoliticianController@deletePolitician'
		));
	
	Route::get('/admin/politicians/', array(
			'as' => 'admin-politicians',
			'uses' => 'PoliticianController@adminlistPoliticians'
		));

	Route::get('/admin/comments/', array(
			'as' => 'admin-comments',
			'uses' => 'CommentController@adminlistComments'
		));
	
	Route::get('create-politician', array(
			'as' => 'create-politician',
			'uses' => 'PoliticianController@createPolitician'
		));
	
	Route::post('create-politician', array(
			'as' => 'create-politician',
			'uses'=> 'PoliticianController@newPolitician'
		));

	Route::get('/admin/politicians/edit/{fullname}', array(
			'as' => 'edit-politician',
			'uses' => 'PoliticianController@editPolitician'
		));

	Route::post('/admin/politicians/edit/{fullname}', array(
			'as' => 'edit-politician',
			'uses' => 'PoliticianController@updatePolitician'
		));

	Route::get('submit-politician', array(
			'as' => 'submit-politician',
			'uses' => 'PoliticianController@getSubmitPolitician'
		));

	Route::post('submit-politician', array(
			'as' => 'submit-politician',
			'uses' => 'PoliticianController@postSubmitPolitician'
		));

	

	Route::post('follow-politician',array(
    			'as' => 'follow-politician',
    			'uses' => 'PoliticianController@follow'
		));




	//Temporary for Importing 'candidates' from old db into 'Politicians'	
	Route::get('candidates', array(
			'as' => 'candidates',
			'uses' => 'PoliticianController@listCandidates'
		));

/***************************Users**************************************/

	Route::get('/users', array(
		'as' => 'users',
		'uses' => 'ProfileController@listUsers'
	));	



	Route::post('delete-user', array(
			'as' => 'delete-user',
			'uses' => 'ProfileController@deleteUser'
		));


	Route::post('deactivate-user', array(
			'as' => 'deactivate-user',
			'uses' => 'ProfileController@deactivateUser'
		));

	
	Route::get('/user/{username}', array(
		'as' => 'profile-user',
		'uses' => 'ProfileController@user'
	));
	
	Route::get('/admin/users/', array(
			'as' => 'admin-users',
			'uses' => 'ProfileController@adminlistUsers'
		));


	Route::get('user/edit/{username}', array(
			'as' => 'edit-user',
			'uses' => 'ProfileController@editUser'
		));
	
	Route::post('user/edit/{username}', array(
			'as' => 'edit-user',
			'uses' => 'ProfileController@updateUser'
		));
	Route::get('create-user', array(
			'as' => 'create-user',
			'uses' => 'ProfileController@createUser'
		));
	Route::post('create-user', array(
			'as' => 'create-user',
			'uses'=> 'ProfileController@newUser'
		));

	Route::post('follow-user',array(
    			'as' => 'follow-user',
    			'uses' => 'ProfileController@follow'
		));


	Route::post('get-username', array(
			'as' => 'get-username',
			'uses' =>'ProfileController@getUsername'
		));
	
	Route::post('get-user', array(
			'as' => 'get-user',
			'uses' => 'ProfileController@getUser'
		));

	Route::post('edit', array(
		'as'=> 'edit-myprofile',
		'uses' => 'ProfileController@postEdit'
	));

	Route::post('update-issues-followed',array(
		'as'=> 'update-issues-followed',
		'uses' => 'ProfileController@updateIssuesFollowed'
	));


/***************************Charts**************************************/

	Route::get('refresh-chart',array(
			'as' => 'refresh-chart',
			'uses' => 'PoliticianController@refreshChart'
		));

	Route::get('test-chart',array(
			'as' => 'refresh-chart',
			'uses' => 'PoliticianController@testChart'
		));

	
	
	
/***************************Comments**************************************/
	

	Route::post('submit-comment',array(
    			'as' => 'submit-comment',
    			'uses' => 'CommentController@submitComment'
		));

	Route::post('vote-comment',array(
    			'as' => 'vote-comment',
    			'uses' => 'CommentController@voteComment'
		));

	Route::post('get-replies', array(
			'as' => 'get-replies',
			'uses' => 'CommentController@getReplies'
		));
	
	


/*
| Sign out (GET)
*/

	Route::get('signout', array(
		'as'=> 'signout',
		'uses' => 'AccountController@getSignOut'
	));


	Route::get('myprofile', array(
		'as'=> 'myprofile',
		'uses' => 'ProfileController@myProfile'
	));


	Route::get('edit', array(
		'as'=> 'edit-myprofile',
		'uses' => 'ProfileController@getEdit'
	));
	/*
	Route::get('rate', array(
		'as'=> 'rate',
		'uses' => 'AccountController@ratePolitician'
	));
	*/	
});



/*
Unauthenticated group
*/



Route::group(array('before' =>'guest'),function(){

	/*
	Crossover Request Forgery Protection
	*/
	
	Route::group(array('before' =>'csrf'), 
	function(){
 		/*
		Create account (POST)
	        */	
		Route::post('create',array(
			'as' => 'create-post',
			'uses' => 'AccountController@postCreate1'
		));
		Route::post('create-1',array(
			'as' => 'create-post-1',
			'uses' => 'AccountController@postCreate1'
		));
		


                /*
		Login account (POST)
		*/
	
		Route::post('login',array(
    			'as' => 'login-post',
    			'uses' => 'AccountController@postLogin'
		));
		});
       /*
	Login account (GET)
	*/
	
	Route::get('login',array(
    'as' => 'login',
    'uses' => 'AccountController@getLogin'
	));

	/*
	Create account (GET)
	*/

	Route::get('create', array(
 		'as' => 'create',

		'uses' => 'AccountController@getCreate1'

	));

	Route::get('create-1',array(
			'as' => 'create-get-1',
			'uses' => 'AccountController@getCreate1'
		));
	


/**/
	Route::get('activate{code}', array(
		'as' => 'activate',
		'uses' => 'AccountController@getActivate'
		));

	});



?>
