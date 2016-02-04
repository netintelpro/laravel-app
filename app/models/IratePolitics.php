<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class IratePolitics extends Eloquent implements UserInterface, RemindableInterface {
	

	use UserTrait, RemindableTrait;

	public function highestPoliticianRank()
	{}


	public function countPoliticians()
	{}
	
	public function countUsers()
	{}


	public function countAdmin()
	{}


	public function countIssues()
	{}

	

	


}

?>
