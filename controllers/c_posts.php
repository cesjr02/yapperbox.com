<?php

class posts_controller extends base_controller {

	public function __construct() {
		parent::__construct();

		// make sure user is logged in if they want to use anything in this controller
		if(!$this->user) {
			Router::redirect("/");
		}
	} 

/*-------------------------------------------------------------------------------------------------
	display new post form
-------------------------------------------------------------------------------------------------*/

	public function add() {

		// setup view
		$this->template->content = View::instance('v_posts_add');
		$this->template->title   = "New Yap";

		// render template
		echo $this->template;

	} 

/*-------------------------------------------------------------------------------------------------
	process new posts
-------------------------------------------------------------------------------------------------*/

	public function p_add() {

		// associate this post with this user
		$_POST['user_id']  = $this->user->user_id;

		// unix timestamp of when this post was created / modified
		$_POST['created']  = Time::now();
		$_POST['modified'] = Time::now();

		// insert
		// Note we didn't have to sanitize any of the $_POST data because we're using the insert method which does it for us
		DB::instance(DB_NAME)->insert('posts', $_POST);

		// quick and dirty feedback
		//  echo "Your post has been added. <a href='/posts/add'>Add another</a>";

		// setup view
		$this->template->content = View::instance('v_posts_p_add');
		$this->template->title   = "Yap Added";

		// render view
		echo $this->template;

	} 

/*-------------------------------------------------------------------------------------------------
	view all posts
-------------------------------------------------------------------------------------------------*/
	
	public function index() {
			
		// set up the View
		$this->template->content = View::instance('v_posts_index');
		$this->template->title   = "Yapper Feed";
		
		// query
		$q = 'SELECT 
			posts.post_id,
			posts.content,
			posts.created,
			posts.user_id AS post_user_id,
			users_users.user_id AS follower_id,
			users.user_id,
			users.first_name,
			users.last_name
		FROM posts
		INNER JOIN users_users 
			ON posts.user_id = users_users.user_id_followed
		INNER JOIN users 
			ON posts.user_id = users.user_id
		WHERE users_users.user_id = '.$this->user->user_id .'
		ORDER BY posts.created DESC';
		
		// run the query, store results in the variable $posts
		$posts = DB::instance(DB_NAME)->select_rows($q);
		
		// pass data to the View
		$this->template->content->posts = $posts;
		
		// render the View
		echo $this->template;
		
	} 

/*-------------------------------------------------------------------------------------------------

-------------------------------------------------------------------------------------------------*/
	
	public function users() {
		
		// set up the View
		$this->template->content = View::instance("v_posts_users");
		$this->template->title   = "Follow Users";
		
		// build the query to get all users
		$q = "SELECT *
			FROM users";
			
		// execute the query to get all the users
		// store the result array in the variable $users
		$users = DB::instance(DB_NAME)->select_rows($q);
		
		// build the query to figure out what connections does this user already have?
		// example: who are they following
		$q = "SELECT *
			FROM users_users
			WHERE user_id = ".$this->user->user_id;
			
		// execute this query with the select_array method
		// select_array will return our results in an array and use the "users_id_followed" field as the index.
		// this will come in handy when we get to the view
		// store our results (an array) in the variable $connections
		$connections = DB::instance(DB_NAME)->select_array($q, 'user_id_followed');
		
		// pass data (users and connections) to the view
		$this->template->content->users			= $users;
		$this->template->content->connections	= $connections;
		
		// render the view
		echo $this->template;
		
	} 

/*-------------------------------------------------------------------------------------------------
	creates a row in the users_users table representing that one user is following another
-------------------------------------------------------------------------------------------------*/
	
	public function follow($user_id_followed) {

		// prepare the data array to be inserted
		$data = Array(
			"created" => Time::now(),
			"user_id" => $this->user->user_id,
			"user_id_followed" => $user_id_followed
			);
	
		// do the insert
		DB::instance(DB_NAME)->insert('users_users', $data);
	
		// send them back
		Router::redirect("/posts/users");

	} 

/*-------------------------------------------------------------------------------------------------
	 removes the specified row in the users_users table, removing the follow between two users
-------------------------------------------------------------------------------------------------*/

	public function unfollow($user_id_followed) {
	
		// delete this connection
		$where_condition = 'WHERE user_id = '.$this->user->user_id.' AND user_id_followed = '.$user_id_followed;
		DB::instance(DB_NAME)->delete('users_users', $where_condition);
	
		// send them back
		Router::redirect("/posts/users");
	
	} 

/*-------------------------------------------------------------------------------------------------
	confirm delete
-------------------------------------------------------------------------------------------------*/
	
	public function delete($post_id) {
		
		// setup view
		$this->template->content = View::instance('v_post_delete');
		$this->template->title   = "Confirm Delete";
		$this->template->content->post_id = $post_id;
		
		// render view
		echo $this->template;
		
	} 

/*-------------------------------------------------------------------------------------------------
	delete post
-------------------------------------------------------------------------------------------------*/

	public function p_delete($post_id) {
	
		// delete this connection
		$where_condition = 'WHERE post_id = '.$post_id;
		DB::instance(DB_NAME)->delete('posts', $where_condition);
				
		// send them back
		Router::redirect("/posts");

	}

} // eoc