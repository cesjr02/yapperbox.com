<?php

class index_controller extends base_controller {

/*-------------------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------------------*/

	public function __construct() {
		parent::__construct();
	} 

/*-------------------------------------------------------------------------------------------------
	 accessed via http://localhost/index/index/
-------------------------------------------------------------------------------------------------*/

	public function index() {
		
		// any method that loads a view will commonly start with this
		// first, set the content of the template with a view file
		$this->template->content = View::instance('v_index_index');
		$this->template->content->loginContent = View::instance('v_users_login');
		// $this->template->content->signupContent = View::instance('v_users_signup');

		// now set the <title> tag
		$this->template->title = "YapperBox";
	
		// CSS/JS includes
			/*
			$client_files_head = Array("");
			$this->template->client_files_head = Utils::load_client_files($client_files);
			
			$client_files_body = Array("");
			$this->template->client_files_body = Utils::load_client_files($client_files_body);
			*/

		// render the view
		echo $this->template;

	} 


} // eoc
