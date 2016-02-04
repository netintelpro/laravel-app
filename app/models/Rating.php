<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Rating extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('issue_id','user_id','politician_id','value');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'ratings';

	public function politician()
    	{
        return $this->belongsTo('Politician');
    	}
	
	public function user()
	{
	return $this->belongsTo('User');

	}


	public function issue()
	{
	return $this->belongsTo('Issue');

	}


	


}

?>
