<div class='col-md-6 col-md-offset-3'>
	<h2 class='h2'>Yapper Feed</h2>
	
		<!-- if post are empty link users to /posts/users/ -->
		<?php if(empty($posts)): ?>	
			<p>
				Click <a href='/posts/users/'>here</a> to start following other users. 
			</p>	
		<?php endif; ?>
		<?php foreach($posts as $post): ?>
	
	<!-- shows posts feed -->
	<article>
		
		<!-- displays 'You posted' for own posts, otherwise displays user's name -->
		<?php if($post['user_id'] == $user->user_id): ?>
			<h3 class='h3'>You Yapped:<h3>
		<?php else: ?>
			<h3 class='h3'><?=$post['first_name']?> <?=$post['last_name']?> Yapped:</h3>
		<?php endif; ?>
		
			<!-- displays post content -->
			<p class='postContent'><?=$post['content']?></p>
		
			<!-- displays time post was created -->
			<p class='datetime'>Yapped on: <time datetime='<?Time::display($post['created'],'Y-m-d G:i')?>'>
			<?=Time::display($post['created'])?>
			</time></p>
		
		<!-- displays delete button on logged in user posts -->
		<?php if($post['user_id'] == $user->user_id): ?>
			<a href='/posts/delete/<?=$post['post_id']?>'><button type='button' class='btn btn-default'>Delete Post</button></a>
		<?php else: ?>
		<?php endif; ?>
	
	</article>
	
		<?php endforeach; ?>
	
</div><!-- end of col -->