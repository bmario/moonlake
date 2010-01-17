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

Moonlake_Autoload_Autoloader::loadInterface("Moonlake_Controller_Controller");

abstract class Moonlake_Controller_ActionController extends Moonlake_Controller_Controller {

    protected $request;
    protected $response;

    public function  __construct(Moonlake_Request_Request $request, Moonlake_Response_Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function __call($name, $args) {
        if(method_exists($this, $name.'_Action')) {
            $this->{$name.'_Action'}();
        }
        else {
            $this->index_Action();
        }
    }

    public abstract function index_Action();
}

?>
