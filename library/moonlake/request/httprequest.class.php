<?php

/*
 * (c) 2009 by Mario Bielert <mario@moonlake.de>
 * Moonlake - Framework
 */

/*
 * This work is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any later version.
 *
 * This work is distributed in the hope that it will be useful,
 * but without any warranty; without even the implied warranty of merchantability
 * or fitness for a particular purpose.
 * See version 2 and version 3 of the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
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
        return null;
    }
    public function issetParam($name) {
        return isset($this->parameters[$name]);
    }
}

?>