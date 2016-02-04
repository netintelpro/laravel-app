<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Politician extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('approved','approved_by','full_name','first_name','rank','last_name','office','district','party','city','bio','state','pic_url','legacy');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'politicians';

	public function users()
    	{
        	return $this->belongsToMany('User','politician_follows');
    	}

	public function ratings()
    	{
        return $this->hasMany('Rating');
    	}

	public function comments()
	{
	return $this->hasMany('Comment');
	}

	public function news()
	{
	return $this->belongsToMany('New','politicians_news');

	}

	public function topIssues()
	{
		//returns list object of issue ids of issues where politician has most votes
		$top_issues = DB::table('ratings')->where('politician_id','=',$this->id)
                 ->select('issue_id', DB::raw('count(*) as total'))
                 ->groupBy('issue_id')->orderBy('total', 'desc')
                 ->get();

		return $top_issues;


	}
	
	


	


}

?>
