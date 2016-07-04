<?php
/**
 * Created by PhpStorm.
 * User: DWIsprananda
 * Date: 7/1/2016
 * Time: 2:16 PM
 */

function librariesAutoload( $class ) {
	$class = str_ireplace('divalia\\', '', $class);
	$libraries_file = dirname(__DIR__."..").'/Libraries/'."$class/$class".'.php';

	if (file_exists($libraries_file)) {
		include_once $libraries_file;
	} else {

		if (stripos($class, 'Whoops') !== false) {
			include_once dirname(__DIR__."../")."/Libraries/Debug/filp/whoops/src/$class.php";
		}

		if (stripos($class, 'debug') !== false) {
			$class = str_ireplace("Symfony\\Component\\Debug\\", '', $class);
			include_once dirname(__DIR__."../")."/Libraries/Debug/symfony/debug/$class.php";
		}
	}
}

spl_autoload_register( 'librariesAutoload' );