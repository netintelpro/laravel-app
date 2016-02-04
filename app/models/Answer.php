<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Answer extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('created_by','created_at','updated_at','question_id','user_id','content');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'poll_answers';

public function question()
    {
        return $this->belongsTo('Question');
    }


	


}

?>
