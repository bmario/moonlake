<?php

/**
 * The Application class
 */
class MyApp extends Moonlake_Application_Application {

	// a list of allowed controllers
	protected $allowed_controller = array('main', 'guestbook');

	// the init methode
	public function init() {
		// use default response and request
		$this->response = new Moonlake_Response_HttpResponse();
		$this->request = new Moonlake_Request_HttpRequest();

		// the boring one :)
		$this->frontctrl = new Moonlake_Controller_DefaultFrontController($this);

		// use the controller here as defaults instead of index_Controller
		$this->frontctrl->setDefaultController('main');
	}
}

?>