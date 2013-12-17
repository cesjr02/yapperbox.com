<div class='col-md-6 col-md-offset-3'>
	<h2 class='h2'>Create Account</h2>
	<p class='p'>Create an account using the form below to experience all the great features YapperBox has to offer.</p>
	<p class='error'>* required field.</p>
						<!-- form for signup -->
						<form method='POST' action='/users/p_signup'>
		
							<div class='form-group'>
								First Name<span class='error'>*</span><br>
								<input type='text' name='first_name' class='form-control input-lg' value='<?php if(isset($_POST['first_name'])) echo $_POST['first_name']?>'>
							</div>
					
							<div class='form-group'>
								Last Name<span class='error'>*</span><br>
								<input type='text' name='last_name' class='form-control input-lg' value='<?php if(isset($_POST['last_name'])) echo $_POST['last_name']?>'>
							</div>
					
							<div class='form-group'>
								Email<span class='error'>*</span><br>
								<input type='text' name='email' class='form-control input-lg' value='<?php if(isset($_POST['email'])) echo $_POST['email']?>'>
							</div>
						
							<div class='form-group'>	
								Password<span class='error'>*</span><br>
								<input type='password' name='password' class='form-control input-lg'>
							</div>
							
							<div class='form-group'>
								Retype Password<span class='error'>*</span><br>
								<input type='password' name='retype' class='form-control input-lg'>
							</div>
					
							<!-- checks to see if error isset. If so, echo specific error. -->		
							<?php if(isset($error)): ?>
								<div class='alert alert-danger'>
									Sign up failed.<br>
									<?php echo $error; ?>
								</div>
							<?php endif; ?>  
								
							<input type='submit' class='btn btn-primary' value='Submit' >

						</form>
</div><!-- end of col -->
