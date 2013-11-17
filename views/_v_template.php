<!DOCTYPE html>
<html>

<head>
	<title><?php if(isset($title)) echo $title; ?></title>
	<meta name='viewport' content='width=device-width, initial-scale=1.0'>
	
	<!-- Bookmark Icon -->
	<link rel='icon' type='image/png' href='images/bookmark-icon/myicon.png' />
	<link rel='shortcut icon' href='/images/bookmark-icon/myicon.png?v=2' />

	<!-- Apple Icon -->
	<link rel='apple-touch-icon-precomposed' href='images/bookmark-icon/apple-touch-iphone.png' />
	<link rel='apple-touch-icon-precomposed' sizes='72x72' href='images/bookmark-icon/apple-touch-ipad.png' />
	<link rel='apple-touch-icon-precomposed' sizes='114x114' href='images/bookmark-icon/touch-icon-iphone-retina.png' />
	<link rel='apple-touch-icon-precomposed' sizes='144x144' href='images/bookmark-icon/apple-touch-ipad-retina.png' />
	

	<!-- Bootstrap -->
	<link href='/css/bootstrap.min.css' rel='stylesheet'>
	
	<!-- style.css -->
	<link href='/css/styles.css' rel='stylesheet'>

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
	<script src='https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js'></script>
	<![endif]-->


	<!-- Controller Specific JS/CSS -->
	<?php if(isset($client_files_head)) echo $client_files_head; ?>
	
</head>

<body>
	<!-- fixed navbar -->
	<nav class='navbar navbar-inverse navbar-fixed-top' role='navigation'>
		<div class='container'>
			<div class='navbar-header'>
			
				<!-- button displays when on mobile devices -->
				<button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'>
					<span class="sr-only">Toggle navigation</span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
					<span class='icon-bar'></span>
				</button>
				
				<a href='/'><img src='/images/logo.png' class='navbar-brand' alt='logo'></a>
			</div>
			
			<div class='collapse navbar-collapse'>
				<ul class='nav navbar-nav navbar-right'>
				
					<!-- Menu for logged in users -->
					<?php if($user): ?>
					<li class='dropdown'>
					
						<a href='#' class='dropdown-toggle' data-toggle='dropdown'><?php echo $user->first_name; ?> <?php echo $user->last_name; ?> <b class='caret'></b></a>
						
						<ul class='dropdown-menu'>
							<li><a href='/users/profile'><span class='glyphicon glyphicon-user'></span> View My Profile</a></li>
							<li class='divider'></li>
							<li><a href='/posts/add'><span class='glyphicon glyphicon-comment'></span> Yap</a></li>
							<li class='divider'></li>
							<li><a href='/posts'><span class='glyphicon glyphicon-th-list'></span> Yapper Feed</a></li>
							<li class='divider'></li>
							<li><a href='/posts/users'><span class='glyphicon glyphicon-link'></span> Connect</a></li>
					
						</ul>
					</li>
						
						<li><a href='/users/logout/'>Sign out</a></li>
						
					<?php else: ?>
					<!-- Menu for users who are not logged in -->
					<li><a href='/'>Home/Login</a></li>
					<li><a href='/users/signup'>Register</a></li>					
					<?php endif; ?>				
				</ul>
			</div>
		</div>
	</nav>


	<div class='container'>
		<div class='row'>
			<?php if(isset($content)) echo $content; ?>
			<?php if(isset($client_files_body)) echo $client_files_body; ?>	 
		</div><!-- end of row -->
	</div><!-- end of container -->


	<!-- footer -->
	<div class='navbar navbar-default navbar-fixed-bottom'>
		<div class='container'>
			<p class='navbar-text pull-right'>2013 YapperBox - Developed and Designed by CJ Sheets</p>
		</div>	
	</div>
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src='https://code.jquery.com/jquery.js'></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src='/js/bootstrap.min.js'></script>
</body>

</html>