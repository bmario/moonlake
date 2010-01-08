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

namespace de\Moonlake\Controller;
use de\Moonlake\Request\Request;
use de\Moonlake\Response\Response;


/**
 * This class ist the default front controller, actually the only one :)
 */
class DefaultFrontController extends Controller implements FrontController {

    private $defaultController = 'index_Controller';
    private $preCommands = null;
    private $postCommands = null;

    public function  __construct() {
        $this->preCommands = new ChainCommand();
        $this->postCommands = new ChainCommand();
    }

    /**
     * This methode invokes everything :)
     * @param Moonlake_Request_Request the request object
     * @param Moonlake_Response_Response the response object
     */
    public function handleRequest(Request $request, Response $response) {

        /*
         * is there a controller requested?
         */
        if($request->issetParam("ctrl")) {
            /*
             *  Controller is set in request
             */
            $ctrl = $request->getParam("ctrl").'_Controller';
        }
        else {
            /*
             * no controller set, use default
             */
            $ctrl = $this->defaultController;
        }

        /*
         * is the action set?
         */
        if($request->issetParam("action")) {
            /*
             * action is set in request
             */
            $action = $request->getParam("action").'_Action';
        }
        else {
            /*
             * use default action 
             */$action = 'index_Action';
        }
        
        if(class_exists($ctrl)) {
            /*
             *  Controller found and included 
             */
            try {
               /*
                * maybe we have the wrong class
                */
               $controller = new $ctrl($request, $response);    
            }
            catch(Exception $e) {
                /*
                 * FIXME throw error if controller is not an actioncontroller
                 */
                echo "Controller isn't an ActionController";
            }
            
            
            if(is_a($controller, 'de\\Moonlake\\Controller\\ActionController')) {
                /*
                 * exists the given action?
                 */
                if(method_exists($controller, $action)) {
                    /*
                     * party! methode exists, so run it :) (and blame the developer if something ist wrong ;)
                     * but don't forget pre and post controllers 
                     */
                    $this->runPreCommands($request, $response);
                    $controller->$action();
                    $this->runPostCommands($request, $response);
                }
                else {
                    /*
                     * FIXME throw error if the requested methode does not exist
                     */
                    echo "The requested action doesn't exists within the controller";
                }
                
            }
            else {
                /*
                 * FIXME throw error if controller is not an actioncontroller
                 */
                echo "Controller isn't an ActionController";
            }
        }
        else {
            /*
             * FIXME throw error if there is no controller
             * maybe implementing an error controller and call it
             */
            echo "Controller not found.";
        }
    }
    
    /**
     * This methode sets the default controller, which is used if there is no controller given
     * @param String controllername without the ending '_Controller' 
     */
    public function setDefaultController($ctrl) {
        $this->defaultController = $ctrl.'_Controller';
    }
    
    /**
     * This methode registers a postcommand.
     * controllers are executed in the same order as they added.
     * 
     * @param Moonlake_Coontroller_Command the command
     */
    public function registerPostCommand(PostCommand $cmd) {
        $this->postCommands->addCommand($cmd);
    }

    /**
     * This methode registers a precommand.
     * controllers are executed in the same order as they added.
     * 
     * @param Moonlake_Coontroller_Command the command
     */
    
    public function registerPreCommand(PreCommand $cmd) {
        $this->preCommands->addCommand($cmd);
    }
    
    /**
     * This methode runs the registerd precontrollers.
     */
    private function runPreCommands(Request $request, Response $response) {
        $this->preCommands->run($request, $response);
    }
    
    /**
     * This methode runs the registerd postcontrollers.
     */
    private function runPostCommands(Request $request, Response $response) {
        $this->postCommands->run($request, $response);
    }
    
}

?>
