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

class Moonlake_Request_HttpRequest implements Moonlake_Request_Request {

    private $parameters;

    public function __construct() {
        $this->parameters = $_REQUEST;
    }

    public function getHeader($name) {
        $name = 'HTTP'.strtoupper(str_replace('-', '_', $name));
        if(isset($_SERVER[$name])) {
            return $_SERVER[$name];
        }
        return null;
    }
    public function getParam($name) {
        if($this->issetParam($name)) {
            return $this->parameters[$name];
        }
        throw new Moonlake_Exception_Moonlake("The parameter $name was not set in the request.");
    }
    public function issetParam($name) {
        return isset($this->parameters[$name]);
    }
}

?>