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

abstract class Moonlake_Controller_ActionController {

    protected $app;

    public function  __construct(Moonlake_Application_Application $app) {
        $this->app = $app;
    }

    public function execute($name) {
        if(method_exists($this, $name)) {
            try {
                $this->$name();
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
    
    public abstract function index_Action();

    public function error_Action() {
        throw new Moonlake_Exception_ActionController("The given action wasn't found", get_class($this), '_Action');
    }
}

?>
