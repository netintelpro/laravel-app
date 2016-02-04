<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Like extends Eloquent implements UserInterface, RemindableInterface {

protected $fillable = array('comment_id','user_id','value');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comment_likes';



public function comment()
    	{
        return $this->belongsTo('Comment');
    
    	}

public function user()
    	{
        return $this->belongsTo('User');

    	}




}

?>
