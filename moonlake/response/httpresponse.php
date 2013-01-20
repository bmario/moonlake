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

    /**
     * Set headers and send content to client.
     */
    public function sendContent() {
        foreach($this->headers as $name => $value) {
            header("{$name}: {$value}");
        }
        ob_start('gz_handler');
        echo $this->output;
        ob_end_flush();
        $this->headers = array();
        $this->output = null;
    }

    /**
     * Append $data to output.
     * @param <String> $data
     */
    public function writeContent($data) {
        $this->output .= $data;
    }

    /**
     * Set the header name to the value type.
     * Be careful with those headers!
     * @see http://www.faqs.org/rfcs/rfc2616
     * @param <String> $name
     * @param <String> $value
     */
    public function addHeader($name,$value) {
        $this->headers[$name] = $value;
    }

    /**
     * Forget all what was set before.
     */
    public function clear() {
        $this->clearContent();
        $this->clearHeaders();
    }

    /**
     * Forget the content
     */
    public function clearContent() {
        $this->output = null;
    }

    /**
     * Forget the headers
     */
    public function clearHeaders() {
        $this->headers = array();
    }

    /**
     * Set a cookie with the name $name and the value $value for a duration of
     * $duration.
     * @param <type> $name
     * @param <type> $value
     * @param <type> $duration
     * @return <boolean> returns true, if successed
     */
    public function setCookie($name, $value, $duration)
    {
        return setcookie($name, $value, time() + $duration, '/');
    }

    /**
     * Returns the output, that was set until now.
     * @return <String> the output
     */
    public function getContent() {
        return $this->output;
    }

    /**
     * On self-destruct send the entiere content.
     */
    public function  __destruct() {
        $this->sendContent();
    }

    /**
     * This function is just a simplification to addHeader("content-type",$type)
     * Be careful with those types.
     * @see http://www.faqs.org/rfcs/rfc2616
     * @param String $type
     */
    public function setContentType($type) {
        $this->headers['Content-Type'] = $type;
    }

    /**
     * This function sets a redirect header, so the browser will be forwarded to
     * the specified controller.
     * @param String controller - The name of the controller
     * @param String action - The name of the action
     * @param String[] args - Further aguments to be passed
     */
    public function redirect($controller="", $action="", $args=array()) {
        $url = '';
        if($controller != "") {
            $url="index.php?ctrl=$controller";

            if($action != "") {
                $url .= "&action=$action";
            }
            if($args != array()) {
                foreach($args as $key => $val)
                $url .= "&$key=$val";
            }

            $this->addHeader('Location', $url);
        }
        else $this->addHeader('Location', 'index.php');

    }
}

?>