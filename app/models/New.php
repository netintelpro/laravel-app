<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class New extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('headline','created_by','created_at','source','updated_at','feature_pic_url','content');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'news';

	public function politicians()
    	{
        	return $this->belongsToMany('Politician','politicians_news');
    	}

	public function issues()
    	{
        return $this->belongsToMany('Issue','issues_news');
    	}

	


}

?>
