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
 * This class is the base class for all ActionControllers.
 * These have actions. The frontcontroller calls those actions.
 */
abstract class Moonlake_Controller_ActionController {

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
                // try to execute it...
                $this->$name();
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
            $this->error_Action();
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
    public function error_Action() {
        throw new Moonlake_Exception_ActionController("The given action wasn't found", get_class($this), '_Action');
    }
}

?>
