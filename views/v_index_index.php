<div class='col-md-8'>
		<h1 class='h1'>Welcome!</h1>	
		<p class='p'>
		Welcome to Yapperbox. Yapperbox is a community where users can easily connect with others and share ideas. Signup and start making connections so you always stay in the loop. Start yapping today!
		</p>					
</div>

<div class='col-md-4'>
	<?php if($user): ?><h2 class='h2'><?php echo $user->first_name; ?> <?php echo $user->last_name; ?> <?php echo "<a href='/users/logout/'>Sign out</a>"; ?></h2>
	<?php else: ?><?=$loginContent;?>
	<?php endif; ?>
</div>
















				



