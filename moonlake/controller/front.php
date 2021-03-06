<?php

/*
 *  Copyright 2009 2010 Mario Bielert <mario@moonlake.de>
 *
 *  This file is part of the Moonlake Framework.
 *
 *  The Moonlake Framework is free software: you can redistribute it
 *  and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation, either version 3 of
 *  the License, or (at your option) any later version.
 *
 *  The Moonlake Framework is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with the Moonlake Framework.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * This is the default implementation of the frontcontroller interface
 */
class Moonlake_Controller_Front {

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
        $ctrl = 'index_Controller';
        if($request->issetParam("ctrl")) {
            // Controller is set in request
            $ctrl = $request->getParam("ctrl").'_Controller';
        }

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
    private function executeCtrlAction($ctrl, $action) {
        // checks if the controller exists and cause of that, load it with autload :)
        if(class_exists($ctrl)) {
            /* Controller found and is now included */

            // instanziate a new object of the controller
            $controller = new $ctrl($this->app);

            // check if the controller has the wright class
            if($controller instanceof Moonlake_Controller_Action) {

                //everything fits, so call the action
                $controller->execute($action);
            }
            else {
                // wrong class
                throw new Moonlake_Exception_FrontController("The given controller isn't a instance of Moonlake_Controller_Action.");
            }
        }
        else {
            // now controller found
            throw new Moonlake_Exception_FrontController("The given controller could not be found.");
        }
    }
}

?>
