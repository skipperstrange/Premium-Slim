<?php

namespace Premium\Models;

class User extends \Illuminate\Database\Eloquent\Model {

	protected $fillables = [ 'apikey'];

	public function authenticate($apikey) {
		$user          = User::where('apikey', '=', $apikey)->take(1)->get();
		$this->details = $user[0];
		return ($user[0]->exists)?true:false;
	}

}
