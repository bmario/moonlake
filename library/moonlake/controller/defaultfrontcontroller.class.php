<?php
/*
 *       Copyright 2009 2010 Mario Bielert <mario@moonlake.de>
 *
 *       This program is free software; you can redistribute it and/or modify
 *       it under the terms of the GNU General Public License as published by
 *       the Free Software Foundation; either version 2 of the License, or
 *       (at your option) any later version.
 *
 *       This program is distributed in the hope that it will be useful,
 *       but WITHOUT ANY WARRANTY; without even the implied warranty of
 *       MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *       GNU General Public License for more details.
 *
 *       You should have received a copy of the GNU General Public License
 *       along with this program; if not, write to the Free Software
 *       Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *       MA 02110-1301, USA.
 */

/**
 * This is the default implementation of the frontcontroller interface
 */
class Moonlake_Controller_DefaultFrontController implements Moonlake_Controller_FrontController {

    private $default_ctrl = 'index_Controller';
    private $app;

	/**
	 * The construct, needs a instance of an applciation
	 * @param Moonlake_Application_Application $app
	 */
    public function __construct(Moonlake_Application_Application $app) {
    	$this->app = $app;
    }

	/**
	 * The main methode of the front controller.
	 * This checks the GET parameter 'ctrl' for any value, concates '_Controller'
	 * and treats the result as the name of the controller, which is to be executed.
	 * The name of the action is read out from the GET parameter 'action' and
	 * appending '_Action' to that.
	 *
	 * If one of these get parameters are empty, the default values are used.
	 */
    public function handleRequest() {
		// read request and response from the app
    	$request = $this->app->getRequest();
    	$response = $this->app->getResponse();

		// build controller name or use default
        $ctrl = $this->default_ctrl;
        if($request->issetParam("ctrl")) {
            // Controller is set in request
            $ctrl = $request->getParam("ctrl").'_Controller';
        }

		// checks if the controller is allowed in the app
		if(!$this->app->isAllowedController($ctrl)) throw new Moonlake_Exception_FrontController("The given controller is not allowed in this application.");

		// build action name or use default
        $action = "index";
        if($request->issetParam("action")) {
            $action = $request->getParam("action");
        }
		$action .= '_Action';

		$this->executeCtrlAction($ctrl, $action);
    }

	/**
	 * This function executes a given controller and the given action. If it
	 * doesn't exist, there will be thrown an exception.
	 * @param String $ctrl
	 * @param String $action
	 */
	public function executeCtrlAction($ctrl, $action) {
		// checks if the controller exists and cause of that, load it with autload :)
        if(class_exists($ctrl)) {
            /* Controller found and is now included */

			// instanziate a new object of the controller
            $controller = new $ctrl($this->app);

			// check if the controller has the wright class
            if($controller instanceof Moonlake_Controller_ActionController) {

				//everything fits, so call the action
                $controller->execute($action);
            }
            else {
				// wrong class
                throw new Moonlake_Exception_FrontController("The given controller isn't a instance of Moonlake_Controller_ActionController.");
            }
        }
        else {
			// now controller found
			throw new Moonlake_Exception_FrontController("The given controller could not be found.");
        }	
	}

	/**
	 * Returns the name of the default controller. This controller is used if
	 * there is no other controller given in GET or anything.
	 *
	 * @return String name of the default controller
	 */
    public function getDefaultController() {
        return $this->default_ctrl;
    }

	/**
	 * This sets the default controller. This is the controller, which is used
	 * if there is no other conrtoller given.
	 *
	 * @param String $name the name of the controller
	 */
    public function setDefaultController($name) {
        if(class_exists($name.'_Controller')) {
            $this->default_ctrl = $name.'_Controller';
        }
    }
}

?>
