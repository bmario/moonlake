<?php

/*
 *  Copyright 2010 Mario Bielert <mario@moonlake.de>
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
 * This class is for controllers, which are embedded in views of ActionControllers.
 * They are a bit different. They don't have an index_Action().
 * The do not have request or response objects!!!
 *
 * Set parameters to every action, if you need one.
 * e.g. login_Action($username, $password){}
 *
 * You can call them with the viewhelper "widget".
 */
class Moonlake_Controller_Widget {
    protected $view;

    public function __construct(Moonlake_View_View $view) {
        $this->view = $view;
    }

    public function execute($action, $arguments) {

            if(method_exists($this, $action)) {
            try {
                // run pre action
                $result = $this->__pre_Action();

                if($result) {
                    $result = call_user_func_array(array($this, $action), $arguments);
                    if($result === false)
                    {
                        throw new Moonlake_Exception_WidgetController("There has happen a critical failure while trying to execute the action '$action'");
                    }
                }
                
                // run post action
                $thia->__post_Action();
                
                return $result;
            }
            catch(Exception $e) {
                try{
                    $this->error_Action();
                }
                catch(Exception $ee) {
                    throw $e;
                }
            }
        }
        else {
            $this->error_Action();
        }

    }

    /**
     * This function is for errorhandling.
     * Override it, to get a nice output, if something goes wrong,
     * or keep it, to use the internal error output.
     *
     * Also you could override it, and do nothing, so you can surpress debug
     * informations in productive usage.
     */
    public function error_Action() {
        throw new Moonlake_Exception_WidgetController("The given action wasn't found", get_class($this), '');
    }
    
    
    /**
     * This function is called BEFORE the action.
     * 
     * If this function returns false, the action WILL NOT be called.
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