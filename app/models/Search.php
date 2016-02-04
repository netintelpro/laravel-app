<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Search extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('search_term','user_id','created_at','updated_at','found');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'searches';

	public function user()
	    {
		return $this->belongsTo('User');
	    }


}

?>
