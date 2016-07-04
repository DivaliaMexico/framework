<?php

/**
 * @param $class
 */
function thirdPartyAutoload( $class ) {
	$ClassArray = explode( '\\', $class );

	if ( isset( $ClassArray[1] ) ) {
		$FileLoad = \Divalia\Config::get( 'path.third_party' ) . '/' . $ClassArray[0] . '/' . $ClassArray[1] . '.php';
	} else {
		$FileLoad = \Divalia\Config::get( 'path.third_party' ) . '/' . $ClassArray[0] . '/' . $ClassArray[0] . '.php';
	}

	if ( php_sapi_name() == 'cli' ) {
		$FileLoad = \Divalia\Config::get( 'path.basepath' ) . '/' . $FileLoad;
	}

	if ( file_exists( $FileLoad ) ) {
		include_once $FileLoad;
	} else {
		$FileLoad = \Divalia\Config::get( 'path.third_party' ) . '/' . $ClassArray[0] . '.php';

		if ( file_exists( $FileLoad ) ) {
			include_once $FileLoad;
		}
	}
	
}

spl_autoload_register( 'thirdPartyAutoload' );