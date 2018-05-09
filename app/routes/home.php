<?php
	register_rest_route( 'wpras/v1', '/home', array(
	    'methods' => 'GET',
	    'callback' => array( HomeController::class, 'index' ),
	) );

	register_rest_route( 'wpras/v1', '/store', array(
	    'methods' => 'POST',
	    'callback' => array( HomeController::class, 'store' ),
	) );
