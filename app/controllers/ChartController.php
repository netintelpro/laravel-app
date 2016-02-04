<?php
use Carbon\Carbon;
class ChartController extends BaseController{

	//require 'vendor/autoload.php';

	//use Carbon\Carbon;



	public function getQuestionChart(){
		$question_id = Input::get('question_id');

		$title = Question::find($question_id)->content;
	        $response = $this->generateQuestionChart($question_id,$title);
		
		
		return Response::json( $response );

	}
	public function generateQuestionChart($question_id, $title)
	{
		$answers = Question::find($question_id)->answers;
		$content = $answers->lists('content');
		$total = 0;
		$index = 0;
		$votes = array();
		foreach($answers as $answer)
		{
			$count = UserAnswer::where('answer_id','=',$answer->id)->count();
			$total += $count;
			$votes[$index++] = $count;
		}
		$index = 0;
		$percentages = array();
		foreach($votes as $vote)
		{
			$percentages[$index++] = round(($vote/$total * 100), 0, PHP_ROUND_HALF_UP);;
				
		}
			
		return array('title'=>$title,'xaxis'=>$content,'percentages'=>$percentages,'votes'=>$votes,'total'=>$total);


	}

	public function getPoliticianChart(){
		
		$politician_id = Input::get('politician_id');

		$title = Politician::find($politician_id)->full_name."'s Approval Over Last 7 Days";
	        $response = $this->generatePoliticianChart($politician_id,$title);

		
		return Response::json( $response );
	}


	public function getUserChart(){
		$user_id = Input::get('user_id');

		$title = User::find($user_id)->username."'s Votes Over Last 7 Days";
	        $response = $this->generateUserChart($user_id,$title);

		
		return Response::json( $response );

	}

	public function chartRange()
	{
		$id = Input::get('id');
		$count = Input::get('count');
		$type = Input::get('type');
		$range = Input::get('range');
		$cat = Input::get('cat');
		$chart =  $this->getChart($range,$id,$cat);
		return Response::json( $chart );

	}

	
	

	private function generateUserChart($user_id,$title,$selected=1)
	{
			//Democrat Ratings: Get value and timestamp of all democrat users' ratings for this politician
                       	$democrat_ratings = $this->makeUserRatings($user_id,'Democrat');

			//Republican Ratings: Get value and timestamp of all republican users' ratings for this politician			
			$republican_ratings = $this->makeUserRatings($user_id,'Republican');

			//Independent Ratings: Get value and timestamp of all republican users' ratings for this politician						
			$independent_ratings = $this->makeUserRatings($user_id,'Independent');

			$unaffiliated_ratings = $this->makeUserRatings($user_id,'Unaffiliated');
			
			//chart data			
			$independent_chart_data = $this->make7DayChartData($independent_ratings);
			$democrat_chart_data = $this->make7DayChartData($democrat_ratings);
			$republican_chart_data = $this->make7DayChartData($republican_ratings);
			$unaffiliated_chart_data = $this->make7DayChartData($unaffiliated_ratings);

			$xaxis = $this->sevenDays();

			$today = new DateTime('NOW');
                        $xaxis = $this->sevenDays();
			
			return array(
				'democrat_chart_data' => $democrat_chart_data,
				'republican_chart_data' => $republican_chart_data,
				'independent_chart_data' => $independent_chart_data,
				'unaffiliated_chart_data' => $unaffiliated_chart_data,
				'id' =>$user_id,
				'xaxis'=>  $xaxis ,
				'selected'=>$selected, //this is the button thats selected initially on range button selection
				'title'=> $title
					);

	}

	
	public function generatePoliticianChart($politician_id,$title,$selected=1)
	{
			//Democrat Ratings: Get value and timestamp of all democrat users' ratings for this politician
                       	$democrat_ratings = $this->makeRatings($politician_id,'Democrat');

			//Republican Ratings: Get value and timestamp of all republican users' ratings for this politician			
			$republican_ratings = $this->makeRatings($politician_id,'Republican');

			//we have raw data. now we need to turn data into format for highchart with appropriate time interval resolution
			//For now we are going to use 7 day intervals. So we are going back 7 days from today.
			//0 on x-axis is 7 days ago. 
			
			//creating array where each index represents a day (whatever time unit in future)
			//For now, 0 is 7 days ago. So we loop through each day and sum up all raw data values that took place during
			//that time unit

			$independent_ratings = $this->makeRatings($politician_id,'Independent');
			$unaffiliated_ratings = $this->makeRatings($politician_id,'Unaffiliated');

			$unaffiliated_chart_data = $this->make7DayChartData($unaffiliated_ratings);

			$independent_chart_data = $this->make7DayChartData($independent_ratings);
			$democrat_chart_data = $this->make7DayChartData($democrat_ratings);

			$republican_chart_data = $this->make7DayChartData($republican_ratings);

			$xaxis = $this->sevenDays();

			$today = new DateTime('NOW');
                        $xaxis = $this->sevenDays();

			return array(
				'democrat_chart_data' => $democrat_chart_data,
				'republican_chart_data' => $republican_chart_data,
				'independent_chart_data' => $independent_chart_data,
				'unaffiliated_chart_data'=> $unaffiliated_chart_data,
				'id' =>$politician_id,
				'xaxis'=>  $xaxis ,
				'selected'=>$selected, //this is the button thats selected initially on range button selection
				'title'=> $title,
	                        'trend' =>Politician::find($politician_id)->ratings->sum('value')
					);
			



	}
	
		private function getName($id,$cat='P')
		{
			if ($cat=='P')
				return Politician::find($id)->full_name;
			else return User::find($id)->username;
		}
		private function getChart($range, $id,$cat='P')
		{
			$democrat_ratings = $this->makeRatings($id,'Democrat',$cat);
			$republican_ratings = $this->makeRatings($id,'Republican',$cat);
			$independent_ratings = $this->makeRatings($id,'Independent',$cat);
			$unaffiliated_ratings = $this->makeRatings($id,'Unaffiliated',$cat);

			$name = $this->getName($id,$cat);
			switch ($range) {
			  case "24h":
			  	{
				       	$democrat_chart_data = $this->make24HourChartData($democrat_ratings);
					$republican_chart_data = $this->make24HourChartData($republican_ratings);
					$independent_chart_data = $this->make24HourChartData($independent_ratings);
					$unaffiliated_chart_data = $this->make24HourChartData($unaffiliated_ratings);
					$xaxis = $this->oneDay();
					return array(
					'title'=>$name."'s Approval Over Last 24 hours",
					'selected'=>0,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
			    		break;
				}
			    
			  case "7d":
				{
					$democrat_chart_data = $this->make7DayChartData($democrat_ratings,7,'day');
					$republican_chart_data = $this->make7DayChartData($republican_ratings,7,'day');
					$independent_chart_data = $this->make7DayChartData($independent_ratings,7,'day');
					$unaffiliated_chart_data = $this->make7DayChartData($unaffiliated_ratings,7,'day');
					$xaxis = $this->sevenDays();	
				    return array(
					'title'=>$name."'s Approval Over Last 7 Days",
					'selected'=>1,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
				    break;
				}
			  case "30d":
				{	$democrat_chart_data = $this->make30DayChartData($democrat_ratings);
					$republican_chart_data = $this->make30DayChartData($republican_ratings);
					$independent_chart_data = $this->make30DayChartData($independent_ratings);
					$unaffiliated_chart_data = $this->make30DayChartData($unaffiliated_ratings);
					$xaxis = $this->thirtyDays();
			    		return array(
					'title'=>$name."'s Approval Over Last 30 Days",
					'selected'=>2,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
			    		break;
				}			  
			  case "6m":
				{	$democrat_chart_data = $this->makeChartData($democrat_ratings,6,'month');
					$republican_chart_data = $this->makeChartData($republican_ratings,6,'month');
					$independent_chart_data = $this->makeChartData($independent_ratings,6,'month');
					$unaffiliated_chart_data = $this->makeChartData($unaffiliated_ratings,6,'month');
					$xaxis = $this->sixMonths();			  	
					return array(
					'title'=>$name."'s Approval Over Last 6 Months",
					'selected'=>3,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
			    		break;
			  	}
			  case "1y":
				{
					$democrat_chart_data = $this->makeChartData($democrat_ratings,12,'month');
					$republican_chart_data = $this->makeChartData($republican_ratings,12,'month');
					$independent_chart_data = $this->makeChartData($independent_ratings,12,'month');
					$unaffiliated_chart_data = $this->makeChartData($unaffiliated_ratings,12,'month');
					$xaxis = $this->oneYear();
					return array(
					'title'=>$name."'s Approval Over Last Year",
					'selected'=>4,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
					break;
				}
			  default:
				{	$democrat_chart_data = $this->make7DayChartData($democrat_ratings,7,'day');
					$republican_chart_data = $this->make7DayChartData($republican_ratings,7,'day');
					$independent_chart_data = $this->make7DayChartData($independent_ratings,7,'day');
					$unaffiliated_chart_data = $this->make7DayChartData($unaffiliated_ratings,7,'day');
					$xaxis = $this->sevenDays();
			    		return array(
					'title'=>$name."'s Approval Over Last 7 Days",
					'selected'=>1,
					'democrat_chart_data' => $democrat_chart_data,
					'republican_chart_data' => $republican_chart_data,
					'independent_chart_data' => $independent_chart_data,
					'unaffiliated_chart_data' => $unaffiliated_chart_data,
					'id' =>$id,
					'xaxis'=>  $xaxis
						);
				}			
			}

		}










		private function makeChartData($ratings,$count = 7, $type="day")
		{
			
			$chart_data = array();
			$count -= 1;

			//zero out y axis 
			for ($x=0; $x<=$count; $x++)
				$chart_data[$x] = 0;
			
			$todays_date = new DateTime("now"); 	 	
			//filter chart data into appropriate yxis
			foreach ($ratings as $rating) {
				$rating_date = new DateTime($rating['created_at']);				
				$r = $rating_date->format($this->getDateFormat($type));
				$t = $todays_date->format($this->getDateFormat($type));	
				$date_interval = abs($t -$r);
				if  ($date_interval<=$count) 
				{
					$chart_data[$count-$date_interval] += $rating['value'];
				}

			}
			return $chart_data;

		}

		private function makeDayChartData($ratings,$count = 7, $type="day")
		{
			
			$chart_data = array();
			$count -= 1;

			//zero out y axis 
			for ($x=0; $x<=$count; $x++)
				$chart_data[$x] = 0;
			
			$todays_date = new DateTime("now"); 	
			//filter chart data into appropriate yxis
			foreach ($ratings as $rating) {
				$rating_date = new DateTime($rating['created_at']);	

				$r = $rating_date->format('m d y');
				$t = $todays_date->format('m d y');	
				$date_interval = $todays_date->diff($rating_date);
				$date_interval = intval($date_interval->format('%d'));
				if  ($date_interval<=$count) 
				{
					$chart_data[$count-$date_interval] += $rating['value'];

				}

			}
			return $chart_data;

		}

		private function make24HourChartData($ratings)
		{
			
			$chart_data = array();
			$count = 23;

			//zero out y axis 
			for ($x=0; $x<=$count; $x++)
				$chart_data[$x] = 0;
			
			$todays_date = new DateTime("now"); 	

			//filter chart data into appropriate yxis
			foreach ($ratings as $rating) {
				$rating_date = new DateTime($rating['created_at']);	
				$date_interval = $todays_date->diff($rating_date);
				if  (($date_interval->h<=24) && ($date_interval->days==0))
				{
					$chart_data[$count-$date_interval->h] += $rating['value'];

				}

			}
			return $chart_data;

		}

		private function make7DayChartData($ratings,$count = 7, $type="day")
		{
			
			$chart_data = array();
			$count -= 1;

			//zero out y axis 
			for ($x=0; $x<=$count; $x++)
				$chart_data[$x] = 0;
			
			$todays_date = new DateTime("now"); 	
			//filter chart data into appropriate yxis
			foreach ($ratings as $rating) {
				$rating_date = new DateTime($rating['created_at']);	

				$r = $rating_date->format('m d y');
				$t = $todays_date->format('m d y');	
				$date_interval = $todays_date->diff($rating_date);
				$date_interval = intval($date_interval->format('%d'));
				if  ($date_interval<=$count) 
				{
					$chart_data[$count-$date_interval] += $rating['value'];

				}

			}
			
			return $chart_data;

		}

		private function make30DayChartData($ratings)
		{
			
			$chart_data = array();
			$count = 29;

			//zero out y axis 
			for ($x=0; $x<=$count; $x++)
				$chart_data[$x] = 0;
			
			$todays_date = new DateTime("now"); 	

			//filter chart data into appropriate yxis
			foreach ($ratings as $rating) {
				$rating_date = new DateTime($rating['created_at']);	

				$r = $rating_date->format('d m y h:m');
				$t = $todays_date->format('d m y h:m');	
				$date_interval = $todays_date->diff($rating_date);
				
				$date_interval = intval($date_interval->format('%d'));

				if  ($date_interval<= $count) 
				{
					$chart_data[$count-$date_interval] += $rating['value'];

				}

			}
			return $chart_data;

		}

		private function makeXAxis($count = 7, $type = 'day')
		{
			
			$xaxis = array(); 
			$count -= 1;
			for ($x=0; $x<=$count; $x++)
				$xaxis[$x] = $x-$count;

		}

		private function getDateFormat($type)
		{
			//http://php.net/manual/en/dateinterval.format.php
			switch ($type) {
				case "hour": 
					return "h";
					break;
				case "day": 
					return "a";
					break;
				case "month": 
					return "m";
					break;
				case "week": 
					return "w";
					break;
				case "year": 
					return "y";
					break;

			}
			  	
		}

		private function makeRatings($id,$party,$cat='P')
		{
			$ratings = array();

			//Hate to throw tacky direct php mysql queries instead of ORM. But having trouble with
			//ORM query logic for inner joins of derived tables. Need beta now and will ORM later.
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");
                        
			if($cat=='P'){
			//Party Ratings: Get value and timestamp of all party users' ratings for this politician
                        $query = "select value,r.created_at from (select * from ratings where politician_id='"
				.$id."') as r inner join (select * from users where party='".$party."') as u on r.user_id = u.id";
			}
			else $query = "select value,r.created_at from (select * from ratings where user_id='".$id."') as r inner join (select * from politicians where party='".$party."') as p on r.politician_id = p.id";		



			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 $ratings[$i++] = array(
					'value'=>$row['value'],
					'created_at' => $row['created_at']
				);
 				 
				}
			mysqli_close($con);
			return $ratings;
		}

		private function makeUserRatings($user_id,$party)
		{
			$ratings = array();
			$con=mysqli_connect("127.0.0.1","root","pepper","iratepolitics");
			 //Democrat Ratings: Get value and timestamp of all democrat politicians' ratings for this user
                        $query = "select value,r.created_at from (select * from ratings where user_id='".$user_id."') as r inner join (select * from politicians where party='".$party."') as p on r.politician_id = p.id";

			$result = mysqli_query($con,$query);
			$i=0;
	
				while($row = mysqli_fetch_array($result)) {
                                 	$ratings[$i++] = array(
					'value'=>$row['value'],
					'created_at' => $row['created_at']
				);
 				 
				}//close while
						
			mysqli_close($con);
			return $ratings;
			
		}		

		private function sevenDays()
		{
			
			$answer = array();
			$i=0;
			for ($x=Carbon::now()->subDays(6); $x<=Carbon::now(); $x->addDay()) {
				$index = $i++;
  				$answer[$index]=$x->format('D d M');

			}
			return $answer;
		}

		private function thirtyDays()
		{
			
			$answer = array();
			$i=0;
			for ($x=Carbon::now()->subdays(30); $x<=Carbon::now(); $x->addDay()) {
				$index = $i++;
  				$answer[$index]=$x->format('d');
			}
			return $answer;
		}

		private function oneDay()
		{
			
			$answer = array();
			$i=0;
			for ($x=Carbon::now()->subHours(23); $x<=Carbon::now(); $x->addHour()) {
				$index = $i++;
  				$answer[$index]=$x->format('g A');

			}
			return $answer;
		}

		private function sixMonths()
		{
			
			$answer = array();
			$i=0;
			for ($x=Carbon::now()->subMonths(5); $x<=Carbon::now(); $x->addMonth()) {
				$index = $i++;
  				$answer[$index]=$x->format('M y');

			}
			return $answer;
		}

		private function oneYear()
		{
			
			$answer = array();
			$i=0;
			for ($x=Carbon::now()->subMonths(11); $x<=Carbon::now(); $x->addMonth()) {
				$index = $i++;
  				$answer[$index]=$x->format('M y');

			}
			return $answer;
		}
		
}


?>
