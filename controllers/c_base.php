<?php

class base_controller {
	
	public $user;
	public $userObj;
	public $template;
	public $email_template;

/*-------------------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------------------*/

	public function __construct() {

		// instantiate User obj
		$this->userObj = new User();

		// authenticate / load user
		$this->user = $this->userObj->authenticate();

		// set up templates
		$this->template 	  = View::instance('_v_template');
		$this->email_template = View::instance('_v_email');

		// so we can use $user in views
		$this->template->set_global('user', $this->user);

	}

} // eoc
