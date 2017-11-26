<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no">
        <title>Jakob Theme</title>
        <?php wp_head(); //prints script data in head?>
    </head>
    <body <?php body_class(); //tells wordpress where body starts ?>
	<nav class="navbar navbar-default" role="navigation">
		<div class="container-fluid">
	        <?php bootstrap_nav(); ?>
	    </div>
	</nav>
	