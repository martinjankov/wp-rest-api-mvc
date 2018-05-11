<?php
	$this->namespace = 'test';
	$this->version = 'v1';

	$this->get('home', 'HomeController@index');
	$this->post('store', 'HomeController@store');
