<?php

/* 

	=====================

	    AJAX FUNCTIONS

	=====================

*/

function jakes_save_contact() {

	//wp_strip_all_tags simply prevents any scripts (html, js, php, etc) from being used as an input buy stripping away tags
	//here we are creating the variables $title, $email, $message and then filling them with the data from the $_POST.
	//$_POST is a php function that stores all of our data that we submitted in the ajax request.
	$title = wp_strip_all_tags($_POST["name"]);
	$email = wp_strip_all_tags($_POST["email"]);
	$message = wp_strip_all_tags($_POST["message"]);

	//sanitizing for extra security
	$title = sanitize_text_field( $title );
	$email = sanitize_text_field( $email );
	$message = sanitize_text_field( $message );

	//anything echoed in this function, will echo inside of the browser's responce field. Uncomment below to test. 
	//echo 'this is in the responce yeah?';

	//arguments for the wp_insert_post function
	$args = array (
		'post_title' => $title,
		'post_content' => $message,
		'post_type' => 'message',
		'post_status' => 'publish',
		'meta_input' => array(
			'_message_email_value_key' => $email
		)
	);

	//inserts a post into the database, also going to store the result in a new variable $postID, since wp_insert_post returns the postID.
	$postID = wp_insert_post( $args );

	//email submission
	if ($postID !== 0 ) {

		$to = get_bloginfo('admin_email');
		$subject = 'Contact Form - '.$title;

		$headers[] = 'From: '.get_bloginfo('name').' <'.$to.'>'; 
		$headers[] = 'Reply-To: '.$title.' <'.$email.'>'; // 'Reply-To: Jake <hello@jakoboliver.com>'
		$headers[] = 'Content-Type: text/html: charset=UTF-8';

		wp_mail($to, $subject, $message, $headers);

		//this will print the newly created post id into the responce field on the browser, so we can tell the jQuery if it was successful
		echo $postID;

	} else {
		//else it will print 0, which signifies an error, which jQuery will pick up and report as such
		echo 0;
	}

	//if we dont use die(); ajax will respond with 0, so we must always add die(); at the end of an ajax function - it's a security feature
	die();

	//this is the end of the contact form execution 
}

add_action ( 'wp_ajax_nopriv_jakes_save_user_contact_form', 'jakes_save_contact');
add_action ( 'wp_ajax_jakes_save_user_contact_form', 'jakes_save_contact');