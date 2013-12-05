// setup the options for ajax
var options = {
	type: 'POST',
	url: '/posts/p_add/',
	beforeSubmit: function() {
		$('#results').html("Adding...");
	},
	success: function(response) {
		$('#results').html(response);
		$('#content').val('');
	}
};

// using the above options ajax the form
$('form').ajaxForm(options);