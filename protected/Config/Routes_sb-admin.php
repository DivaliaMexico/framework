<?php
$RoutesDir  = dirname( __DIR__ . '..' ) . '/Routes';
$RouteFiles = scandir( $RoutesDir );

if ( count( $RouteFiles ) > 2 ) {

	foreach ( $RouteFiles as $idx => $RouteFile ) {

		if ( $RouteFile == '.' || $RouteFile == '..' || pathinfo( $RoutesDir . $RouteFile, PATHINFO_EXTENSION ) != 'php' ) {
			unset( $RouteFiles[ $idx ] );
			continue;
		}

		include_once $RoutesDir . '/' . $RouteFile;
	}

	if ( count( $RouteFiles ) > 0 ) {
		return;
	}
}

//** Home
$app->get( '/', 'SBAdmin@index' )->template( 'sb-admin/sb-admin' );

//** Flot
$app->get( 'flot', 'SBAdmin@flot' )->template( 'sb-admin/sb-admin' );

//** Morris
$app->get( 'morris', 'SBAdmin@morris' )->template( 'sb-admin/sb-admin' );

//** Tables
$app->get( 'tables', 'SBAdmin@tables' )->template( 'sb-admin/sb-admin' );

//** Forms
$app->get( 'forms', 'SBAdmin@forms' )->template( 'sb-admin/sb-admin' );

//** Panels and Wells
$app->get( 'panels-wells', 'SBAdmin@panelsWells' )->template( 'sb-admin/sb-admin' );

//** Buttons
$app->get( 'buttons', 'SBAdmin@buttons' )->template( 'sb-admin/sb-admin' );

//** Notifications
$app->get( 'notifications', 'SBAdmin@notifications' )->template( 'sb-admin/sb-admin' );

//** Typography
$app->get( 'typography', 'SBAdmin@typography' )->template( 'sb-admin/sb-admin' );

//** Icons
$app->get( 'icons', 'SBAdmin@icons' )->template( 'sb-admin/sb-admin' );

//** Icons
$app->get( 'grid', 'SBAdmin@grid' )->template( 'sb-admin/sb-admin' );

//** Blank
$app->get( 'blank', 'SBAdmin@blank' )->template( 'sb-admin/sb-admin' );

//** Login
$app->get( 'login', function () {
} )->template( 'sb-admin/login' );

//** Route Like Codeigniter index.php/Controller/Method/Param1/Params2/Param3.../ParamsN
/*$app->get(':controller', function ($controller) {
    $controller = 'Controller\\' . ucfirst($controller);
    $c = new $controller($this);
    return $c->index();
})->template('basic/basic');

$app->get(':controller/:method', function ($controller, $method) {
    $controller = 'Controller\\' . ucfirst($controller);
    $c = new $controller($this);
    return call_user_func_array([$c, $method], []);
})->template('basic/basic');

$app->get(':controller/:method/:params+', function ($controller, $method, $params = []) {
    $controller = 'Controller\\' . ucfirst($controller);
    $c = new $controller($this);
    return call_user_func_array([$c, $method], $params);
})->template('basic/basic');

$app->post(':controller/:method/:params+', function ($controller, $method, $params = []) {
    $controller = 'Controller\\' . ucfirst($controller);
    $c = new $controller($this);
    return call_user_func_array([$c, $method], $params);
});*/
//-- END Route Like CodeIgniter
