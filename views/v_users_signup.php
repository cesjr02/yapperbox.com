<div class='col-md-6 col-md-offset-3'>
	<h2 class='h2'>Create Account</h2>
	<p class='p'>Create an account using the form below to experience all the great features YapperBox has to offer.</p>
	<p class='error'>* required field.</p>
						<!-- form for signup -->
						<form method='POST' action='/users/p_signup'>
		
							First Name<span class='error'>*</span><br>
							<input type='text' name='first_name' class='form-control input-lg' value='<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>'><br>
					
							Last Name<span class='error'>*</span><br>
							<input type='text' name='last_name' class='form-control input-lg' value='<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>'><br>
					
							Email<span class='error'>*</span><br>
							<input type='text' name='email' class='form-control input-lg' value='<?php if(isset($_POST['email'])) echo $_POST['email']?>'><br>
						
								
							Password<span class='error'>*</span><br>
							<input type='password' name='password' class='form-control input-lg'>
							<br>
							
							Retype Password<span class='error'>*</span><br>
							<input type='password' name='retype' class='form-control input-lg'>
					
							<!-- checks to see if error isset. If so, echo specific error. -->		
							<?php if(isset($error)): ?>
								<div class='error'>
									Sign up failed.<br>
									<?php echo $error; ?>
								</div>
							<?php endif; ?>  
								
						
							<br>
							<input type='submit' class='btn btn-primary' value='Submit' >

						</form>
</div><!-- end of col -->
