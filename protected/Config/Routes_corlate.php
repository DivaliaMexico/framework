<?php
//** Home
$app->get('/', 'Corlate@index')->template('corlate/corlate');

//** About
$app->get('about', 'Corlate@about')->template('corlate/corlate');

//** Services
$app->get('services', 'Corlate@services')->template('corlate/corlate');

//** Portfolio
$app->get('portfolio', 'Corlate@portfolio')->template('corlate/corlate');

//** Blog Item
$app->get('blog-item', 'Corlate@blogItem')->template('corlate/corlate');

//** Pricing
$app->get('pricing', 'Corlate@pricing')->template('corlate/corlate');

//** 404
$app->get('404', 'Corlate@error404')->template('corlate/404');
//** Shortcodes
$app->get('shortcodes', 'Corlate@shortcodes')->template('corlate/corlate');

//** Blog
$app->get('blog', 'Corlate@blog')->template('corlate/corlate');

//** Contact
$app->get('contact', 'Corlate@contact')->template('corlate/corlate');

//** Send Email
$app->post('sendmail', 'Corlate@sendmail');

//** Route Like Codeigniter index.php/Controller/Method/Param1/Params2/Param3.../ParamsN
/*$app->get(':controller', function($controller) {
	$controller = 'Controller\\'.ucfirst($controller);
	$c = new $controller($this);
	return $c->index();
})->template('basic/basic');

$app->get(':controller/:method', function($controller, $method) {
	$controller = 'Controller\\'.ucfirst($controller);
	$c = new $controller($this);
	return call_user_func_array([$c, $method], []);
})->template('basic/basic');

$app->get(':controller/:method/:params+', function($controller, $method, $params=[]) {
	$controller = 'Controller\\'.ucfirst($controller);
	$c = new $controller($this);
	return call_user_func_array([$c, $method], $params);
})->template('basic/basic');

$app->post(':controller/:method/:params+', function($controller, $method, $params=[]) {
	$controller = 'Controller\\'.ucfirst($controller);
	$c = new $controller($this);
	return call_user_func_array([$c, $method], $params);
});*/
//-- END Route Like CodeIgniter