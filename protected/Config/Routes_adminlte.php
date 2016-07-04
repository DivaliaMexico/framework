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
$app->get( '/', 'AdminLTE@index' )->template( 'adminlte/adminlte' );

//** Home 2
$app->get( 'index2', 'AdminLTE@index2' )->template( 'adminlte/adminlte' );

/**
 * Layout
 */
$app->group('layout', function() {
	//** Top Nav
	$this->get('top-nav', 'AdminLTE@index')->template('adminlte/adminlte');

	//** Boxed
	$this->get('boxed', 'AdminLTE@index')->template('adminlte/adminlte');

	//** Fixed
	$this->get('fixed', 'AdminLTE@index')->template('adminlte/adminlte');

	//** Sidebar
	$this->get('sidebar', 'AdminLTE@index')->template('adminlte/adminlte');
});
//---

//** Widgets
$app->get( 'widgets', 'AdminLTE@widgets' )->template( 'adminlte/adminlte' );

/**
 * Charts
 */
$app->group('charts', function() {
	//** Morris
	$this->get( 'morris', 'AdminLTE@morris')->template( 'adminlte/adminlte' );

	//** Flot
	$this->get( 'flot', 'AdminLTE@flot')->template( 'adminlte/adminlte' );

	//** Inline
	$this->get( 'inline', 'AdminLTE@inline' )->template( 'adminlte/adminlte' );
});
//---

/**
 * UI
 */
$app->group('ui', function() {
	//** UI General
	$this->get( 'general', 'AdminLTE@uiGeneral' )->template( 'adminlte/adminlte' );

	//** UI Icons
	$this->get( 'icons', 'AdminLTE@uiIcons')->template( 'adminlte/adminlte' );

	//** UI Buttons
	$this->get( 'buttons', 'AdminLTE@uiButtons')->template( 'adminlte/adminlte' );

	//** UI Sliders
	$this->get( 'sliders', 'AdminLTE@uiSliders' )->template( 'adminlte/adminlte' );

	//** UI Timeline
	$this->get( 'timeline', 'AdminLTE@uiTimeline' )->template( 'adminlte/adminlte' );

	//** UI Modals
	$this->get( 'modals', 'AdminLTE@uiModals' )->template( 'adminlte/adminlte' );
});
//---

/**
 * Forms
 */
$app->group('forms', function () {
	//** Forms General
	$this->get( 'general', 'AdminLTE@formsGeneral' )->template( 'adminlte/adminlte' );

	//** Forms Advanced
	$this->get( 'advanced', 'AdminLTE@formsAdvanced' )->template( 'adminlte/adminlte' );

	//** Forms Editors
	$this->get( 'editors', 'AdminLTE@formsEditors' )->template( 'adminlte/adminlte' );

});
//---

/**
 * Tables
 */
$app->group('tables', function() {
	//** Tables Simple
	$this->get( 'simple', 'AdminLTE@tablesSimple' )->template( 'adminlte/adminlte' );

	//** Tables Data
	$this->get( 'data', 'AdminLTE@tablesData' )->template( 'adminlte/adminlte' );
});
//---

//** Calendar
$app->get( 'calendar', 'AdminLTE@calendar' )->template( 'adminlte/adminlte' );

//** Mailbox
$app->get( 'mailbox', 'AdminLTE@mailbox' )->template( 'adminlte/adminlte' );

//** Mailbox Compose
$app->get( 'mailbox-compose', 'AdminLTE@mailboxCompose' )->template( 'adminlte/adminlte' );

//** Mailbox Read Mail
$app->get( 'mailbox-read-mail', 'AdminLTE@mailboxReadMail' )->template( 'adminlte/adminlte' );

/**
 * Examples
 */
$app->group('examples', function() {
	//** Invoice
	$this->get( 'invoice', 'AdminLTE@Invoice' )->template( 'adminlte/adminlte' );

	//** Invoices
	$this->get( 'invoice-print', function () {
		$this->config->set( 'path.assets', 'assets/adminlte' );
		//** CSS
		$this->assets->css->delete( 'bootstrap-theme.min' );
		$this->assets->css->delete( 'starter-template' );
		$this->assets->css->add( 'bootstrap.min' );
		$this->assets->css->add( 'font-awesome.min' );
		$this->assets->css->add( 'ionicons.min' );

		$this->assets->css->add( 'AdminLTE.min' );
		$this->assets->css->add( 'skins/_all-skins.min' );
		//-- END CSS

		//** JS
		$this->assets->js->add( 'jQuery-2.1.3.min' );
		$this->assets->js->add( 'bootstrap.min' );
		$this->assets->js->add( 'jquery-ui.min' );
		$this->assets->js->add( 'jquery.slimscroll.min' );
		$this->assets->js->add( 'fastclick.min' );
		//-- END JS
	} )->template( 'adminlte/invoice-print' );

	//** Login
	$this->get( 'login', function () {
		$this->config->set( 'path.assets', 'assets/adminlte' );
		//** CSS
		$this->assets->css->delete( 'bootstrap-theme.min' );
		$this->assets->css->delete( 'starter-template' );
		$this->assets->css->add( 'bootstrap.min' );
		$this->assets->css->add( 'font-awesome.min' );
		$this->assets->css->add( 'ionicons.min' );

		$this->assets->css->add( 'AdminLTE.min' );
		$this->assets->css->add( 'skins/_all-skins.min' );
		//-- END CSS

		//** JS
		$this->assets->js->add( 'jQuery-2.1.3.min' );
		$this->assets->js->add( 'bootstrap.min' );
		$this->assets->js->add( 'jquery-ui.min' );
		$this->assets->js->add( 'jquery.slimscroll.min' );
		$this->assets->js->add( 'fastclick.min' );

		$this->assets->js->add( 'app.min' );
		$this->assets->js->add( 'demo' );

		$this->assets->css->add( 'iCheck/all' );
		$this->assets->js->add( 'iCheck/icheck.min' );
		//-- END JS
	} )->template( 'adminlte/login' );

	//** Register
	$this->get( 'register', function () {
		$this->config->set( 'path.assets', 'assets/adminlte' );
		//** CSS
		$this->assets->css->delete( 'bootstrap-theme.min' );
		$this->assets->css->delete( 'starter-template' );
		$this->assets->css->add( 'bootstrap.min' );
		$this->assets->css->add( 'font-awesome.min' );
		$this->assets->css->add( 'ionicons.min' );

		$this->assets->css->add( 'AdminLTE.min' );
		$this->assets->css->add( 'skins/_all-skins.min' );
		//-- END CSS

		//** JS
		$this->assets->js->add( 'jQuery-2.1.3.min' );
		$this->assets->js->add( 'bootstrap.min' );
		$this->assets->js->add( 'jquery-ui.min' );
		$this->assets->js->add( 'jquery.slimscroll.min' );
		$this->assets->js->add( 'fastclick.min' );

		$this->assets->js->add( 'app.min' );
		$this->assets->js->add( 'demo' );

		$this->assets->css->add( 'iCheck/all' );
		$this->assets->js->add( 'iCheck/icheck.min' );
		//-- END JS
	} )->template( 'adminlte/register' );

	//** Lock Screen
	$this->get( 'lockscreen', function () {
		$this->config->set( 'path.assets', 'assets/adminlte' );
		//** CSS
		$this->assets->css->delete( 'bootstrap-theme.min' );
		$this->assets->css->delete( 'starter-template' );
		$this->assets->css->add( 'bootstrap.min' );
		$this->assets->css->add( 'font-awesome.min' );
		$this->assets->css->add( 'ionicons.min' );

		$this->assets->css->add( 'AdminLTE.min' );
		$this->assets->css->add( 'skins/_all-skins.min' );
		//-- END CSS

		//** JS
		$this->assets->js->add( 'jQuery-2.1.3.min' );
		$this->assets->js->add( 'bootstrap.min' );
		$this->assets->js->add( 'jquery-ui.min' );
		$this->assets->js->add( 'jquery.slimscroll.min' );
		$this->assets->js->add( 'fastclick.min' );

		$this->assets->js->add( 'app.min' );
		$this->assets->js->add( 'demo' );
		//-- END JS
	} )->template( 'adminlte/lockscreen' );

	//** 404
	$this->get( '404', 'AdminLTE@error404' )->template( 'adminlte/adminlte' );

	//** 500
	$this->get( '500', 'AdminLTE@error500' )->template( 'adminlte/adminlte' );

	//** Blank
	$this->get( 'blank', 'AdminLTE@blank' )->template( 'adminlte/adminlte' );
});
//---

//** Route Like Codeigniter index.php/Controller/Method/Param1/Params2/Param3.../ParamsN
/*$app->get(
    ':controller',
    function ($controller) {
        $controller = 'Controller\\' . ucfirst($controller);
        $c = new $controller($this);
        return $c->index();
    }
)->template('basic/basic');

$app->get(
    ':controller/:method',
    function ($controller, $method) {
        $controller = 'Controller\\' . ucfirst($controller);
        $c = new $controller($this);
        return call_user_func_array(array($c, $method), array());
    }
)->template('basic/basic');

$app->get(
    ':controller/:method/:params+',
    function ($controller, $method, $params = array()) {
        $controller = 'Controller\\' . ucfirst($controller);
        $c = new $controller($this);
        return call_user_func_array(array($c, $method), $params);
    }
)->template('basic/basic');

$app->post(
    ':controller/:method/:params+',
    function ($controller, $method, $params = array()) {
        $controller = 'Controller\\' . ucfirst($controller);
        $c = new $controller($this);
        return call_user_func_array(array($c, $method), $params);
    }
);*/
//-- END Route Like CodeIgniter
