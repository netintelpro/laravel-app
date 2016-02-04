<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Question extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('poll_id','created_by','created_at','updated_at','content');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'poll_questions';

 public function poll()
    {
        return $this->belongsTo('Poll');
    }


public function answers()
    {
        return $this->hasMany('Answer');
    }	


	


}

?>
