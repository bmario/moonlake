<?php
/*
 *       Copyright 2009 Mario Bielert <mario@moonlake.de>
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

class Moonlake_Controller_SimpleFrontController implements Moonlake_Controller_FrontController {
    
    private $default_ctrl = 'index_Controller';

    public function handleRequest(Moonlake_Request_Request $request, Moonlake_Response_Response $response) {
        $ctrl = $this->default_ctrl;
        if($request->issetParam("ctrl")) {
            // Controller is set in request
            $ctrl = $request->getParam("ctrl").'_Controller';
        }
        $action = "index";
            
        if($request->issetParam("action")) {
            $action = $request->getParam("action");
        }
        if(class_exists($ctrl)) {
            /* Controller found and included */
            $controller = new $ctrl($request, $response);
            
            if($controller instanceof Moonlake_Controller_ActionController) {
                $controller->$action();
            }
            else {
                echo "Given controller isn't a instance of Moonlake_Controller_ActionController";
            }
        }
        else {
            //FIXME throw error if there is no controller
            //maybe implementing an error controller and call it
            echo "Controller not found.";
        }
    }

    public function getDefaultController() {
        return $this->default_ctrl;
    }

    public function setDefaultController($name) {
        if(class_exists($name.'_Controller')) {
            $this->default_ctrl = $name.'_Controller';
        }
    }
}

?>
