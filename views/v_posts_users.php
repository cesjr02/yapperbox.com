<div class='col-md-8'>

	<h2 class='h2'>Follow some Yappers</h2>
	
	<p>Choose to follow or unfollow from the list of users below.</p>
	
	<? foreach($users as $yapper): ?>
	
		<!-- you can't unfollow yourself so your button isn't shown -->
		<?php if ($user->user_id != $yapper['user_id']) : ?>
	
			<!-- print this user's name -->
			<h3 class='h3'><?=$yapper['first_name']?> <?=$yapper['last_name']?></h3>
			
			<!-- if there exists a connection with this user, show a unfollow link -->
			<? if(isset($connections[$yapper['user_id']])): ?>
				<a href='/posts/unfollow/<?=$yapper['user_id']?>'><input type='submit' value='Unfollow' class='btn btn-primary' ></a>
				
			<!-- otherwise, show the follow link -->
			<? else: ?>
				<a href='/posts/follow/<?=$yapper['user_id']?>'><input type='submit' value='Follow' class='btn btn-default' ></a>
			<? endif; ?>
			<br>
		
		<?php endif; ?>
	
	<? endforeach; ?>

</div><!-- end of col -->