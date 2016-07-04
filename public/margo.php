<?php
require "../systems/Core/Divalia.php";

$dir_config = dirname( __DIR__ . '..' ) . '/protected/Config/';

//** Disable this if you run on php version 5.4 is can run on php 5.5
require( $dir_config . "Debug.php" );

$config = require( $dir_config . "Config.php" );
//$config['path.basepath'] = __DIR__.'/';

$app = new Divalia\Divalia( $config );

	$lib_database = $app->config->get( 'libraries' );
	if ( $lib_database['Database']['enable'] ) {
		$app->db->connect();
	}

	require( $dir_config . "Container.php" );

	if ( $app->config->get( 'auth.enable' ) ) {
		Divalia\Auth::init();
	}

	require( $dir_config . "Routes_margo.php" );

$app->run();