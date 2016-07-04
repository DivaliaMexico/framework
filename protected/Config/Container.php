<?php
/*use Models\Users;

$user_post     = $app->config->get( 'auth.post_username' );
$password_post = $app->config->get( 'auth.post_password' );
$username      = $app->request->post( $user_post );
$password      = $app->request->post( $password_post );

if ( ! empty( $username ) && ! empty( $password ) ) {
	$users = Users::find( array(
		'where' => array(
			array( $app->config->get( 'auth.field_username' ), '=', $username ),
		)
	) );

	if ( count( $users ) > 0 ) {

		if ( $users[0]->ldap == 1 ) {
			$app->config->set( 'auth.mode', 'ldap' );
		} else {
			$app->config->set( 'auth.mode', 'database' );
		}

	}
}*/

$app->container['welcomeController'] = function ( $container ) {
	return new Controllers\Welcome();
};

$app->container['corlateController'] = function ( $container ) {
	return new Controllers\Corlate();
};

$app->container['margoController'] = function ( $container ) {
	return new Controllers\Margo();
};

$app->container['sbadminController'] = function ( $container ) {
	return new Controllers\SBAdmin();
};

$app->container['adminlteController'] = function ( $container ) {
	return new Controllers\AdminLTE();
};