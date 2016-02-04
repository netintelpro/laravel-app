<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Comment extends Eloquent implements UserInterface, RemindableInterface {

protected $fillable = array('parent_id','user_id','content','politician_id','rank');
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'comments';


public function updateRank()
{
	$likes = Like::where('comment_id','=',$this->id)->get();
	$rank = 0;
	foreach($likes as $like)
		$rank += $like->value;
	$this->rank = $rank;
	$this->save();

}
public function replies()
    	{
        return $this->hasMany('Comment', 'parent_id');
    	}

public function likes()
	{
	        return $this->hasMany('Like');
	}

public function parent()
    	{
        return $this->belongsTo('Comment', 'parent_id');
    
    	}

public function user()
    	{
        return $this->belongsTo('User');

    	}

public function politician()
    	{
        return $this->belongsTo('Politician');
    	}

public function article()
    	{
        return $this->belongsTo('New');
    	}
}

?>
