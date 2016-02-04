<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class State extends Eloquent implements UserInterface, RemindableInterface {
	
protected $fillable = array('state_id');	
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'states';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	public function candidates()
	{
		return $this->hasMany('Candidate');
	}
	

	
	


	
}
