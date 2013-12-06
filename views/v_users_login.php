<h2 class='h2'>Log in</h2>	
<!-- form for user login -->	
<form method='POST' action='/users/p_login'>
			
	Email<br>
	<input type='email' name='email' class='form-control input-lg' required>
	<br>
				
	Password<br>
	<input type='password' name='password' class='form-control input-lg' required>
	<br>
		
	<!-- shows error if login failed -->		
	<?php if(isset($error)): ?>
		<div class='error'>
			Login failed. Please double check your email and password.
		</div>
		<br>
	<?php endif; ?>
				
	<input type='submit' value='Log in' class='btn btn-primary'>
			
</form>