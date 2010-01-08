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

namespace de\Moonlake\View;
use de\Moonlake\Response\Response;
use de\Moonlake\Cache\Cache;

class View {

    private $assigns = array();
    private $expands = array();
    private $template = "";
    private $xml = "";
    private $render = "";
    private $response = null;

    public function __construct(Response $response) {
        $this->response = $response;

    }

    public function assign($name, $value) {
        $this->assigns[$name] = $value;
    }

    public function render($template) {
        $temp = new Template($template);
        foreach($this->assigns as $key => $value) {
            $temp->assign($key, $value);
        }
        $cache = new Cache('view');
        if(!$cache->valid($template)) $temp->render();
        $this->response->write($temp->execute());
    }
}

?>
