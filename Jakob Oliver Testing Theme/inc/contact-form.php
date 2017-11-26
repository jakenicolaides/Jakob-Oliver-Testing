<form id="jakes-contact-form" class="needs-validation" action = "#" method="post" data-url="<?php echo admin_url('admin-ajax.php'); ?> " novalidate>
	<div class="form-group">
		<input type="text" class="form-control" placeholder="Your Name" id="name" name="name" required>
		<div class='invalid-feedback'>
			Please enter your name.
		</div>
	</div>
	<div class="form-group">
		<input type="email" class="form-control" placeholder="Your Email" id="email" name="email" required>
		<div class='invalid-feedback'>
			Please provide a valid email address.
		</div>
	</div>
	<div class="form-group">
		<textarea type="message" class="form-control" placeholder="Your Message" id="message" name="message" required></textarea>
		<div class='invalid-feedback'>
			Please enter a message.
		</div>
	</div>
	<button type="submit" class="btn btn-default">Submit</button>
	<small class="text-info hide-initial js-form-submission">Submission in progress, please wait...</small>
	<small class="text-success hide-initial js-form-success">Message submited, thank you!</small>
	<small class="text-danger hide-initial js-form-error">There was a problem, please try again</small>
</form>	


		
		