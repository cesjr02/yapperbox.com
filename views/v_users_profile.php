<div class='col-md-8'>
	<h2 class='h2'>My Profile</h2>
	
	<!-- displays user's name and date joined -->
	<h4>Name: <span><?=$user->first_name?> <?=$user->last_name?></span></h4>
	<h4>Join Date: <span><?= date('F j, Y', $user->created) ?></span></h4>    
	
	<!-- displays placeholder image for new users -->     
	<?php if ($user->image  == 'placeholder.jpg'): ?>
	<?php endif; ?>
	
		<form method='POST' enctype='multipart/form-data' action='/users/p_profile/'>
		
			<!-- displays user image if uploaded -->
			<img class='avatar' src='/uploads/avatars/<?=$user->image ?>' alt='<?=$user->first_name . ' ' . $user->last_name ?>'><br />
			<h4>Update profile picture:</h4>
			<input type='file' name='file' id='file'><br>
			
			<!-- error if wrong file type is uploaded -->
			<?php if(isset($error)): ?>
				<div class='error'>
					Upload failed.<br /> 
					Upload must be an image file; jpg, gif, or png.
				</div>
			<?php endif; ?>
			
			<input type='submit' name='submit' value='Update' class='btn btn-primary' user='Submit'>
				
		</form><br>
	<hr>
	<h4>Delete Account</h4>
	<p>Click<a href='/users/unsubscribe/'> here </a>if you wish to delete your account.</p>
</div><!-- end of col -->
