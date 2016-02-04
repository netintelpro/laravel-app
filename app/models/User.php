<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	
	protected $fillable = array('email','username','password','password_temp','code','active','bio','first_name'
	,'last_name','party','pic_url','city','state','birth_month','birth_day','birth_year','sex','role','last_login_at'
	,'last_logout_at','last_ip_address','response_notice','rank_notice','thread_notice');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	public function users()
	{	
		return $this->belongsToMany('User', 'user_follows', 'user_id', 'following_id');

	}
	
	public function isAdmin()
	{
		return $this->role == 'admin';	
	}

	public function likes()
	{
	        return $this->hasMany('Like');
	}

	public function following_user($following_user_id)
	{
		//return true if this user is following user id entered
		return DB::table('user_follows')->where('following_id','=', $following_user_id)->count();
;
	}
	public function politicians()
    	{
        	return $this->belongsToMany('Politician','politician_follows');
    	}

	public function issues()
    	{
        	return $this->belongsToMany('Issue','issues_follows');
    	}

	
	public function ratings()
    	{
        return $this->hasMany('Rating');
    	}
	
	public function comments()
	{
	return $this->hasMany('Comment');	
	}

	public function answers()
    	{
        	return $this->hasMany('Answer','user_answers');
    	}



	
}
