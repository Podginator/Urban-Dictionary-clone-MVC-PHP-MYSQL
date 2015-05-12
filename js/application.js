$(function() {

	$('.editForm').click(function() {
		$('.BioForm').show();
		$('.Biograpy').hide();
	});
    $(window).scroll(function () {
        if ($(this).scrollTop() > 0) {
            $('header').css('position', 'fixed');
        } else if ($(this).scrollTop() <= 0) {
            $('header').css('position', 'relative');
        }
    });

    $(".expandable").click(function(){
    	var elem = $(this).attr('class').split(' ')[1];
    	if(!($('.'+elem).hasClass("down")))
    	{
    		$('.hidden.'+elem).slideDown();
    		$('.hidden.'+elem).addClass("down");
    	}
    	else
    	{
    		$('.hidden.'+elem).slideUp();
    		$('.hidden.'+elem).removeClass("down");
    	}
    });

	function ValidateRegForm()
	{
		var isValid = true;
		$(".Err").text("");
		var uname = $('#uname').val();
		var pass = $('#password').val();
		var confPass = $("#Confirm").val();
		var email = $('#email').val();

		if(name == '' && pass == '' && confPass == '' & email == '')
		{
			$("<h2>Make Sure all inputs are filled</h2>").insertAfter(".Err");
			isValid = false;
		}

		if(!email.match(/^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/)){
			$("<h2>Email Invalid</h2>").insertAfter(".Err");
			$("#email").css("borderColor", "red");
			isValid = false;
		}

		if(pass.length < 6)
		{
			//Decided on just a length requirement, we could require necessary Letters, Chars
			//etc and forbid typical passwords, but for an application like this
			//That stores no user info etc this is fine
			$("<h2>Password Too Short</h2>").insertAfter(".Err");
			$("#password").css("borderColor", "red");
			isValid = false;
		}

		if(pass!=confPass)
		{
			$("<h2>Make Passwords don't match.</h2>").insertAfter(".Err");
			$("#password").css("borderColor", "red");
			$("#Confirm").css("borderColor", "red");
			isValid = false;
		}

		return isValid;
	}

	function ValidatePostForm()
	{
		//This doesn't need to be long, we want to be able to create an Empty Entry, without content. Therefore all we need to check is if the title is long.
		return $("#postTitle").val().length > 0;
	}


	$("#regform").bind("submit", ValidateRegForm);
	$("#addPostForm").bind("submit", ValidatePostForm);




});

