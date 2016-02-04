<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class IssueRating extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('issue_id','user_id','politician_id','value');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'issues_ratings';

	


}

?>
