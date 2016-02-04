<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Issue extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('issue_name','created_by');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'issues';

	public function users()
    	{
        	return $this->belongsToMany('User','issues_follows');
    	}

	//users() and followers() provide same info. Wanted more descriptive function name without having to change where
	//users() is already deployed....for now
	public function followers()
    	{
        	return $this->belongsToMany('User','issues_follows');
    	}

	public function ratings()
    	{
        return $this->hasMany('Rating');
    	}

	public function news()
    	{
        	return $this->belongsToMany('New','issues_news');
    	}

	private function getPoliticianNews($politician_name, $issue_name)
	{

            //    $issue_name = "";

	//	$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=".$politician_name."+".$issue_name;

	//	$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=obama";
	//	$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q='".str_replace(' ', '%20', $politician_name)
       //         ."'+'".str_replace(' ', '%20',$issue_name)."'";


		$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q=obama";
		$URL_CURLOPT =  'https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q="'
		.str_replace(" ", "%20", "'".$politician_name."'")
                .'"+"'.str_replace(" ", "%20","'".$issue_name."'");

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

	public function googleNews($politician_name)
	{
		return $this->getPoliticianNews($politician_name, $this->issue_name )	;	
	
	}

	public function gNews()
	{
		$URL_CURLOPT =  "https://ajax.googleapis.com/ajax/services/search/news?v=1.0&q='".str_replace(' ', '%20', $this->issue_name)."'";

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
	


}

?>
