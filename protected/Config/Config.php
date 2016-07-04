<?php
return array(
	'path.assets'         => 'assets/basic',
	'path.mvc'            => '../protected',
	'path.template'       => '../protected/Templates',
	'path.third_party'    => '../protected/Third_party',
	'mod_rewrite'         => FALSE,

	// Authentic Mode
	'auth.enable'         => FALSE,
	'auth.mode'           => 'database', //** Database (database) or LDAP (ldap)
	'auth.ldap_host'      => '', //** LDAP Host
	'auth.ldap_domain'    => '', //** LDAP Domain
	'auth.ldap_basedn'    => '', //** LDAP basedn
	'auth.ldap_group'     => '', //** LDAP GROUP
	// For Database Authentic
	'auth.model'          => 'Users', //** Model Class
	'auth.field_username' => 'username', //** name Username field in table Database
	'auth.field_password' => 'password', //** name Password field in table Database
	'auth.field_level'    => 'level', //** name Level field in table Database
	// Custom encryption function default is md5
	/*'auth.encrypt_function' => function($password) {
		return md5($password);
	},*/

	'auth.post_username'  => 'username', //** name in <input type="text" name="username" />
	'auth.post_password'  => 'password', //** name in <input type="password" name="password" />
	'auth.login_url'      => 'login', //** login route
	'auth.logout_url'     => 'logout', //** logout route
	'auth.login_template' => 'adminlte/login', //** login template
	//--

	'libraries' => require( "Autoload.php" )
);