<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Poll extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('created_by','created_at','updated_at','title');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'polls';

	

	public function questions()
    {
        return $this->hasMany('Question');
    }
	


}

?>
