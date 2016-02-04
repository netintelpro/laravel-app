<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class UserAnswer extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('answer_id','user_id','created_at','updated_at','content');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'user_answers';

	public function user()
    	{
        	return $this->belongsTo('User','user_answers');
    	}


}

?>
