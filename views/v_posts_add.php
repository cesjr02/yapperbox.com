<div class='col-md-6 col-md-offset-3'>
	<!-- form for adding a new post -->
	<form method='POST' action='/posts/p_add'>
		
		<!-- maxlength defined as 255 -->
		<h2 class='h2'>Yap about something.</h2>
		<textarea maxlength='255' name='content' id='content' class='form-control' rows='3' required></textarea>
		<br>
		<input type='submit' class='btn btn-primary' value='Yap'>
		
	</form>
</div><!-- end of col -->