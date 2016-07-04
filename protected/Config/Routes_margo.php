<?php
//** Home
$app->get('/', 'Margo@index')->template('margo/margo');

//** Index1
$app->get('index1', 'Margo@index1')->template('margo/margo');

//** Index2
$app->get('index2', 'Margo@index2')->template('margo/margo');

//** Index3
$app->get('index3', 'Margo@index3')->template('margo/margo');

//** Index4
$app->get('index4', 'Margo@index4')->template('margo/margo');

//** Index5
$app->get('index5', 'Margo@index5')->template('margo/margo');

//** Index6
$app->get('index6', 'Margo@index6')->template('margo/margo');

//** Index7
$app->get('index7', 'Margo@index7')->template('margo/margo');

//** About
$app->get('about', 'Margo@about')->template('margo/margo');

//** Services
$app->get('services', 'Margo@services')->template('margo/margo');

//** Right Sidebar
$app->get('right-sidebar', 'Margo@rightSidebar')->template('margo/margo');

//** Left Sidebar
$app->get('left-sidebar', 'Margo@leftSidebar')->template('margo/margo');

//** 404
$app->get('404', 'Margo@error404')->template('margo/margo');

//** Tabs
$app->get('tabs', 'Margo@tabs')->template('margo/margo');

//** Buttons
$app->get('buttons', 'Margo@buttons')->template('margo/margo');

//** Action Box
$app->get('action-box', 'Margo@actionBox')->template('margo/margo');

//** Lastest Testimonials
$app->get('lastest-testimonials', 'Margo@lastestTestimonials')->template('margo/margo');

//** Lastest Posts
$app->get('lastest-posts', 'Margo@lastestPosts')->template('margo/margo');

//** Lastest Project
$app->get('lastest-projects', 'Margo@lastestProjects')->template('margo/margo');

//** Pricing Table
$app->get('pricing', 'Margo@pricing')->template('margo/margo');

//** Accordion Toggles
$app->get('accordion-toggles', 'Margo@accordionToggles')->template('margo/margo');

//** Portfolio 2 Column
$app->get('portfolio2', 'Margo@portfolio2')->template('margo/margo');

//** Portfolio 3 Column
$app->get('portfolio3', 'Margo@portfolio3')->template('margo/margo');

//** Portfolio 4 Column
$app->get('portfolio4', 'Margo@portfolio4')->template('margo/margo');

//** Single Project
$app->get('single-project', 'Margo@singleProject')->template('margo/margo');

//** Blog Right Sidebar
$app->get('blog-right-sidebar', 'Margo@blogRightSidebar')->template('margo/margo');

//** Blog Left Sidebar
$app->get('blog-left-sidebar', 'Margo@blogLeftSidebar')->template('margo/margo');

//** Blog Single Post
$app->get('single-post', 'Margo@singlePost')->template('margo/margo');

//** Contact
$app->get('contact', 'Margo@contact')->template('margo/margo');

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