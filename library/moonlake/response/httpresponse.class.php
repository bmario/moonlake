<?php

/*
 * (c) 2009 2010 by Mario Bielert <mario@moonlake.de>
 *
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