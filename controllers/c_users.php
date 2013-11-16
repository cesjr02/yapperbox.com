<?php 

class users_controller extends base_controller {

	public function __construct() {
		parent::__construct();
	} 

	public function index() {
		echo "This is the index page";
	}
	
/*-------------------------------------------------------------------------------------------------
	display a form so users can sign up               
-------------------------------------------------------------------------------------------------*/

	public function signup() {

		// setup view
		$this->template->content = View::instance('v_users_signup');

		// set page title
		$this->template->title = "Sign up";

		// render view
		echo $this->template;

	} 
	
/*-------------------------------------------------------------------------------------------------
	process the sign up form    
-------------------------------------------------------------------------------------------------*/
	
	public function p_signup() {
	
		// setup view
		$this->template->content = View::instance('v_users_signup');

		// initial error to false
		$error = false;

		// initiate error
		$this->template->content->error = '<br>';

		// if we have no post data just display the View with signup form
		if(!$_POST) {
			echo $this->template;
			return;
		}

		// otherwise...
		// loop through the POST data
		foreach($_POST as $field_name => $value) {

			// if a field was blank, add a message to the error View variable
			if(trim($value) == "") {
				$error = true;
				$this->template->content->error = 'All fields are required.';
			}
		} 

		// check whether this user's email already exists (sanitize input first)
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);
		$exists = DB::instance(DB_NAME)->select_field("SELECT email FROM users WHERE email = '" . $_POST['email'] . "'");

		if (isset($exists)) {
			$error = true;
			$this->template->content->error = 'This email address has already been registered, please try again.';
			echo $this->template;
		}

		// check if password is typed correctly
		else if ($_POST['password'] != $_POST['retype']) {
			$error = true;
			$this->template->content->error = 'Password fields don&apos;t match.';
			echo $this->template;
		}

		// if no previous errors, add to database
		else if(!$error) {
		
			// add XSS and html tag filtering
			$firstname = $_POST['first_name'];
			$firstname = strip_tags(htmlentities(stripslashes(nl2br($firstname)),ENT_NOQUOTES,"Utf-8"));

			// add XSS and html tag filtering
			$lastname = $_POST['last_name'];
			$lastname = strip_tags(htmlentities(stripslashes(nl2br($lastname)),ENT_NOQUOTES,"Utf-8"));

			// unset the 'retype' field (not needed in db)
			unset($_POST['retype']);

			// more data we want stored with the user
			$_POST['created']  = Time::now();
			$_POST['modified'] = Time::now();

			// encrypt the password
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

			// create an encrypted token via their email address and a random string
			$_POST['token'] = sha1(TOKEN_SALT.$_POST['email'].Utils::generate_random_string());

			// insert this user into the database
			$user_id = DB::instance(DB_NAME)->insert('users', $_POST);

			// all users follow their own posts by default
			$data = Array(
				"created" => Time::now(),
				"user_id" => $user_id,
				"user_id_followed" => $user_id
				);

			// do the insert
			DB::instance(DB_NAME)->insert('users_users', $data);

			// log user in using the token we generated
			setcookie("token", $_POST['token'], strtotime('+1 year'), '/');

			// send an email a welcome message to the new user
			// build a multi-dimension array of recipients of this email
			$to[]    = Array("name" => $_POST['first_name'], "email" => $_POST['email']);
			$from    = Array("name" => APP_NAME, "email" => APP_EMAIL);
			$subject = "Welcome to YapperBox";
			$body = View::instance('e_users_welcome');

			// Send email
			Email::send($to, $from, $subject, $body, true, '');

			// signup confirm
			Router::redirect("/users/profile");
		}
		else {
			echo $this->template;
			
		} 
		 
	} 

/*-------------------------------------------------------------------------------------------------
	display a form so users can login
-------------------------------------------------------------------------------------------------*/

	public function login($error = NULL) {
		
		// setup view
		$this->template->content = View::instance('v_users_login');

		// setup page title
		$this->template->title   = "Login";

		// pass data to the view
		$this->template->content->error = $error;

		// render view
		echo $this->template;
   
	} 

/*-------------------------------------------------------------------------------------------------
	process login form
-------------------------------------------------------------------------------------------------*/

	public function p_login() {

		// sanitize the user entered data to prevent SQL Injection Attacks
		$_POST = DB::instance(DB_NAME)->sanitize($_POST);

		// hash submitted password so we can compare it against the one in the DB
		$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

		// search the DB for this email and password
		// retrieve the token if it's available
		$q = "SELECT token
			FROM users
			WHERE email = '".$_POST['email']."'
			AND password = '".$_POST['password']."'";

		$token = DB::instance(DB_NAME)->select_field($q);

		// looks for matching token in DB
		if(!$token) {

			// token not found. Login failed, sends user back to login
			Router::redirect("/users/login/error");

		}
		else {

			setcookie("token", $token, strtotime('+1 year'), '/');

			// token found, login successful
			Router::redirect("/users/profile/");
			// echo "You are logged in!";
		}
		
	} 

/*-------------------------------------------------------------------------------------------------
	logout, redirects to "/"
-------------------------------------------------------------------------------------------------*/

	public function logout() {

		// generate and save a new token for next login
		$new_token = sha1(TOKEN_SALT.$this->user->email.Utils::generate_random_string());

		// create the data array we'll use with the update method
		// in this care, we're only updated one field, so our array only has one entry
		$data = Array("token" => $new_token);

		// do the update
		DB::instance(DB_NAME)->update("users", $data, "WHERE token = '".$this->user->token."'");

		// delete their token cookie by setting it to a date in the past -  effectively logging them out
		setcookie("token", "", strtotime('-1 year'), '/');

		// send them back to the main index
		Router::redirect("/");

	} 

/*-------------------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------------------*/

	public function profile($error = NULL) {

		// if user is blank, they're not logged in; redirect them to the login page
		if(!$this->user) {
			Router::redirect('/users/login');
		}

		// if they weren't redirected away, continue:

		// setup view
		$this->template->content = View::instance('v_users_profile');
		$this->template->title = $this->user->first_name .' ' . $this->user->last_name. " | Profile";

		// pass errors, if any
		$this->template->content->error = $error;

		// render view
		echo $this->template;

	} 
	
/*-------------------------------------------------------------------------------------------------
	profile upload avatar
-------------------------------------------------------------------------------------------------*/

	public function p_profile() {
		// if user specified a new image file, upload it
		if ($_FILES["file"]["error"] == 0)
		{
			//upload an image
			$image = Upload::upload($_FILES, "/uploads/avatars/", array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG"), $this->user->user_id);

			if($image == 'Invalid file type.') {
				// return an error
				Router::redirect("/users/profile/error"); 
			}
			else {
				// process the upload
				$data = Array("image" => $image);
				DB::instance(DB_NAME)->update("users", $data, "WHERE user_id = ".$this->user->user_id);

				// resize the image
				$imgObj = new Image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $image);
				$imgObj->resize(200,200, "crop");
				$imgObj->save_image($_SERVER["DOCUMENT_ROOT"] . '/uploads/avatars/' . $image); 
			}
		}
		else
		{
			// return an error
			Router::redirect("/users/profile/error");  
		}

		// Redirect back to the profile page
		router::redirect('/users/profile'); 
	} 
	

/*-------------------------------------------------------------------------------------------------
	unsubscribe page
-------------------------------------------------------------------------------------------------*/

	public function unsubscribe($error = NULL) {

		// setup View
		$this->template->title = "Delete Account";
		$this->template->content = View::instance('v_users_unsubscribe');
		$this->template->content->error = $error;

		// render template
		echo $this->template;

	}

/*-------------------------------------------------------------------------------------------------
	process unsubscribe
-------------------------------------------------------------------------------------------------*/

	public function p_unsubscribe() {
	
		$error = '';
		if ($_POST['password'] != $_POST['conf_password']) {
			$error = 'InvalidPassword';
		}

		else {
			// sanitize the user entered data to prevent SQL Injection Attacks
			$_POST = DB::instance(DB_NAME)->sanitize($_POST);

			// hash submitted password so we can compare it against one in the db
			$_POST['password'] = sha1(PASSWORD_SALT.$_POST['password']);

			// search the db for this email and password
			// retrieve the token if it's available
			$q = "SELECT token 
				FROM users 
				WHERE email = '".$this->user->email."' 
				AND password = '".$_POST['password']."'";

			$token = DB::instance(DB_NAME)->select_field($q);
				if (!$token) {
					$error = 'InvalidPassword';
				}
				
				else {
				// all checks passed, now cleanup the DB from this user
				// deletes user, their posts, and all connections in users_users
				$w = 'WHERE user_id = '.$this->user->user_id;
				DB::instance(DB_NAME)->delete('users', $w);
				}
				
				}
					if ($error != '') {
						Router::redirect("/users/unsubscribe/$error");
					}
					
					else {
						Router::redirect("/");
					}
	} 
 

} // eoc