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
 * This class is the base class for all ActionControllers.
 * These have actions. The frontcontroller calls those actions.
 */
abstract class Moonlake_Controller_Action {

    protected $app;

    /**
     * The contrutor needs the application. You can access in eery action to
     * this given application with "$this->app".
     *
     * @param Moonlake_Application_Application $app
     */
    public function  __construct(Moonlake_Application_Application $app) {
        $this->app = $app;
    }

    /**
     * This function executes a given action.
     *
     * @param String $name the name of the action
     */
    public function execute($name) {
        // if the method exists...
        if(method_exists($this, $name)) {
            try {
                // run pre action
                $result = $this->__pre_Action();
                
                // try to execute it, if pre action returned true
                if($result) $this->$name();
                
                // run post action
                $this->__post_Action();
                
            }
            catch(Exception $e) {
                // if this fails, try the error action...
                try{
                    $this->error_Action();
                }
                catch(Exception $ee) {
                    // if the error action fails, throw the exception further.
                    throw $e;
                }
            }
        }
        else {
            // if method not exists, call error action
            $this->error_Action($name);
        }
    }

    /**
     * Every controller has to have a index action.
     */
    public abstract function index_Action();

    /**
     * This function is for errorhandling.
     * Override it, to get a nice output, if something goes wrong,
     * or keep it, to use the internal error output.
     *
     * Also you could override it, and do nothing, so you can surpress debug
     * informations in productive usage.
     */
    public function error_Action($action) {
        throw new Moonlake_Exception_ActionController("The called action ".get_class($this)."->{$action}() does not exists.");
    }
    
    /**
     * This function is called BEFORE the action.
     * 
     * If this function returns false, the Action WILL NOT be called.
     * 
     * @return boolean 
     */
    protected function __pre_Action()
    {
        return true;
    }
    
    /**
     * This function is called AFTER the action.
     */
    protected function __post_Action()
    {
        
    }
}

?>
