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

class Moonlake_Response_HttpResponse implements Moonlake_Response_Response {

    private $headers = array();
    private $output = null;

    public function send() {
        foreach($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        echo $this->output;
        $this->headers = array();
        $this->output = null;
    }
    public function write($data) {
        $this->output .= $data;
    }
    public function addHeader($name,$value) {
        $this->headers[$name] = $value;
    }

    public function clear() {
        $this->output = null;
        $this->headers = array();
    }

    public function setCookie($name, $value, $duration)
    {
        return setcookie($name, $value, time() + $duration, '/');
    }

    public function get() {
        return $this->output;
    }

    public function  __destruct() {
        $this->send();
    }
}

?>