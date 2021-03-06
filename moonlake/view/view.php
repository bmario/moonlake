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
 * These are classes for representing small templates.
 */
class Moonlake_View_View {

    protected $__assigns__ = array();
    protected $__design__;

    /**
     * The constructor needs the design name and the templatename
     * @param Moonlake_Repsonse_Repsonse the usesd repsonse
     * @param String $design the design name
     */
    public function __construct($design) {
        $this->__design__    = $design;
    }

    /**
     * This assigns content to variables which can be used within templates
     * @param String $name the name for the variable
     * @param any $value the value of the variable
     */
    public function assign($name, $value) {
        $this->__assigns__[$name] = $value;
    }
    public function __set($name, $value) {
        $this->assign($name, $value);
    }

    /**
     * This magic methode is used to read the variable values
     * @param String $name the name of the variable
     * @return any the value of the given variable, if it's set
     */
    public function __get($name) {
        if(isset($this->__assigns__[$name])) return $this->__assigns__[$name];
        else
            throw new Moonlake_Exception_View("The value '$name' was not set in this view.");
    }

    /**
     * The isset() and unset() function should work also :)
     */
    public function __unset($name) {
        if(isset($this->__assigns__[$name])) unset($this->__assigns__[$name]);
    }
    public function __isset($name) {
        return isset($this->__assigns__[$name]);
    }

    /**
     * This method returns the rendered template, this means, with all variables
     * filled in.
     * @return String the rendered template
     */
    public function render($name) {
        if(!file_exists($this->getPath($name))) throw new Moonlake_Exception_View('Cannot find template '.$name.' in design '.$this->__design__.'. Expected it under '.$this->getPath($name));

        // start output buffering
        ob_start();

        try{
            // include file if exists and so execute the php inside
            include($this->getPath($name));
        }
        catch(Exception $e) {
            ob_end_clean();
            throw $e;
        }

        // read the output from the buffer
        $render = ob_get_contents();

        // clean and end buffer
        ob_end_clean();

        // return the rendered template
        return $render;
    }

    /**
     * This only builds the path to the template
     * @return String path to template
     */
    protected function getPath($name) {
        return 'application/view/'.$this->__design__.'/templates/'.$name.'.phtml';
    }

    /**
     * Returns the relative path to the design root.
     * Useful for images and stuff
     * @return String the path
     */
    public function getBasePath() {
        return 'application/view/'.$this->__design__.'/';
    }


    public function  __call($name,  $arguments) {
        $class = $name.'_ViewHelper';
        if(class_exists($class)) {
            $vh = new $class();
            return $vh->execute($this, $arguments);
        }
        else {
            throw new Moonlake_Exception_View("The ViewHelper $class could not be found.");
        }
    }
}

?>
