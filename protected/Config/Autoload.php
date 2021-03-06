<?php
require "Third_party.php";

return array(
	'DIC'      => array( 'enable' => TRUE ),
	'Cookie'   => array(
		'enable' => FALSE,
		'config' => array( 'encrypt' => FALSE )
	),
	'Session'  => array(
		'enable' => FALSE,
		'config' => array( 'encrypt' => FALSE )
	),
	'Database' => array(
		'enable' => FALSE,
		'config' => require( "Database.php" )
	),
	'MVC'      => array( 'enable' => TRUE ),
	'Language' => array(
		'enable' => FALSE,
		'params' => array()
	)
);