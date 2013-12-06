<div class='col-md-8'>
		<h1 class='h1'>Welcome!</h1>	
		<p class='p'>
		Welcome to Yapperbox. Yapperbox is a community where users can easily connect with others and share ideas. Signup and start making connections so you always stay in the loop. Start yapping today!
		</p>					
</div>

<div class='col-md-4'>
	<?php if($user): ?><h2 class='h2'>Hello, <?php echo $user->first_name; ?></h2>
	<p class='p'>Click <?php echo "<a href='/users/profile/'>here</a>"; ?> to go to your profile.</p>
	<?php else: ?><?=$loginContent;?>
	<?php endif; ?>
</div>
















				



