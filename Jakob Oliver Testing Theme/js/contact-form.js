jQuery(document).ready( function($){
	
	// contact form submission 
	$('#jakes-contact-form').on('submit', function(e){

		//stops the broswer from doing the default thing, such as open a new page, on submit*/
		e.preventDefault();

		$('.js-show-feedback').removeClass('js-show-feedback');

		/*creates a form variable, and gives it the value of its parent variable, in this case: #jakes-contact-form
		this stops the function {('#name').val();"} from looking everywhere in the DOM for #name and gets it to
		just search in this form for the id. - basically, it is reducing the scope*/
		var form = $(this);
		
		//so now we are searching inside our form for elements with ID #name, and putting this into name variable
		var name = form.find('#name').val();

		/*check out the variables by uncommenting this code - notice how it prints details of the variable/object of
		the form, and also the name that you entered into the form. This proves to us that var name is definitly
		storing the name entered into the form.*/
		//console.log(form);
		//console.log(name);
		
		//now we are doing the same with the rest of the inputs on our form
		var email = form.find('#email').val();
		var message = form.find('#message').val();

		/* ===============
		    ajax section
		   =============== */

		//makes new variable, gets url from data attribute data-url from html element in the form  
		var ajaxurl = form.data('url');

		
		//bootstrap validation hightlighting 
		if( name === '' ){
			$('#name').addClass('is-invalid');
		}
		else {
			$('#name').removeClass('is-invalid');
			$('#name').addClass('is-valid');
		}

		if( email == '' ){
			$('#email').addClass('is-invalid');
		}
		else {	
			$('#email').removeClass('is-invalid');
			$('#email').addClass('is-valid');
		}

		if( message == '' ){
			$('#message').addClass('is-invalid');
		}
			else {
			$('#message').removeClass('is-invalid');
			$('#message').addClass('is-valid');
		}


		//check before ajax - this stops empty fields from being submitted
		if ( name === '' || email == '' || message == '' ) {
			return;
		}

		//functions to validate email clientside
		function validateEmail(email) {
  			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  			return re.test(email);
		}

		function validate() {
		  $("#result").text("");
		  var email = $("#email").val();
		  if (validateEmail(email)) {
		    $('#email').addClass('is-valid');
		    $('#email').removeClass('is-invalid');
		  } else {
		    $('#email').addClass('is-invalid');
		  }
		  return false;
		}

		//running the validate function
		validate();
		if ($('#email').hasClass('is-invalid')) {
			return;
		}

		//disabling input on submit
		form.find('input, button, textarea').attr('disabled', 'disabled');
		$('.js-form-submission').addClass('js-show-feedback');
		

		//the ajax request
		$.ajax({

			url : ajaxurl,
			type : 'post',
			data : {

				name : name,
				email : email,
				message : message,
				action : 'jakes_save_user_contact_form'
			},
			
			//if unable to complete the request then output the responce
			error : function ( response ){
				$('.js-form-submission').removeClass('js-show-feedback');	
				$('.js-form-error').addClass('js-show-feedback');
				form.find('input, button, textarea').removeAttr('disabled');
			},

			//if able to complete the request, but the wp_insert_post(); fails.
			success : function ( response ){
				if ( response == 0 ){
					setTimeout(function(){
						$('.js-form-submission').removeClass('js-show-feedback');	
						$('.js-form-error').addClass('js-show-feedback');
						form.find('input, button, textarea').removeAttr('disabled');
					},1000);
					
				}	
				else {
					setTimeout(function(){
						$('.js-form-submission').removeClass('js-show-feedback');	
						$('.js-form-success').addClass('js-show-feedback');
						form.find('input, button, textarea').removeAttr('disabled').val('');
					},1000);	
				}
			}
		});
	});
});