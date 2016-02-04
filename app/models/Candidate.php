<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Candidate extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('copied','updated_at');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'candidates';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	
	
	public function state()
    	{
        	return $this->belongsTo('State');
    	}
	


	
}
