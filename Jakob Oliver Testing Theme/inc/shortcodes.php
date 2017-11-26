<?php 

//contact form shortcode

function jakes_contact_form( $atts, $content = null ) {

	//get the attributes, creates a shortcode called [contact_form]
	$atts = shortcode_atts(
		array(),
		$atts,
		'contact_form'
	);

	//return HTML
	include get_template_directory() .'/inc/contact-form.php';
}

add_shortcode( 'contact_form', 'jakes_contact_form');
