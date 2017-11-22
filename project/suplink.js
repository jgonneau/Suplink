function submit_register()
{
	if ($('#email').val().indexOf('@') == -1 || $('#email').val().indexOf('.') == -1)
	{
		$('#email_register_error').css('opacity','1.0');
		$('#password').val('');
		$('#password2').val('');
		return false;
	}

	if($('#password').val() != $('#password2').val())
	{
		$('#password_register_error').css('opacity','1.0');
		$('#password').val('');
		$('#password2').val('');
		return false;	
		
	}
	
	return true;

	

}
