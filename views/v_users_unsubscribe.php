<div class='col-md-6 col-md-offset-3'>

	<h2 class='h2'>Delete Account</h2>
	
	<p>Are you sure you wish to delete your account? This cannot be undone. If not, click <a href='/users/profile/'>here </a>to return.</p>
	<p class='error'>* required field.</p>
	
		<!-- form for delete account-->
		<form method='POST' action='/users/p_unsubscribe'>
		
			Password<span class='error'>*</span><br>
			<input type='password' name='password' class='form-control input-lg'><br>

			Confirm Password<span class='error'>*</span><br>

			<input type='password' name='conf_password' class='form-control input-lg'>
			<br>

				<!-- checks to see if error isset. If so, echo specific error. -->
				<?php if(isset($error)): ?>
					<div class='alert alert-danger'>
						Please enter a valid password.<br>
					</div>
				<?php endif; ?>
				
				<input type='submit' value ='Unsubscribe' class='btn btn-primary'>
		
		</form>

</div><!-- end of col -->