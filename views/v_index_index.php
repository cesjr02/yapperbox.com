<div class='col-md-6'>
	<!-- If User is logged in -->
	<?php if($user): ?>
		<h1 class='h1'>Hello,  <?php if($user): ?><?php echo $user->first_name; ?><?php endif; ?>.</h1>
		
	<!-- If User is NOT logged in -->
	<?php else: ?>
		<h1 class='h1'>Welcome!</h1>
	<?php endif; ?> 
			
		<p class='p'>
		Welcome to Yapperbox. Yapperbox is a community where users can easily connect with others and share ideas. Signup and start making connections so you always stay in the loop. Start yapping today!
		</p>
						
</div>

<div class='col-md-6'>
	<?=$loginContent;?>
</div>
















				



