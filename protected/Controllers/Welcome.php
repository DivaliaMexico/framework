<?php
namespace Controllers;

use Divalia\Controller;

class Welcome extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function index() {
		return $this->view('index');
	}
}
