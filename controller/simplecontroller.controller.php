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

class simplecontroller_Controller extends Moonlake_Controller_ActionController
{
    public function index_Action() {
        $view = new simplecontroller_View();
        if($this->request->issetParam("name")) {
            $view->index_View()->assign("name", $this->request->getParam("name"));
        }
        else {
            $view->index_View()->assign("name", "Gast");
        }
        $view->index_View()->render($this->response);
    }

    public function byby_Action() {
        $view = new simplecontroller_View();
        if($this->request->issetParam("name")) {
            $view->byby_View()->assign("name", $this->request->getParam("name"));
        }
        else {
            $view->byby_View()->assign("name", "Gast");
        }
        $view->byby_View()->render($this->response);
    }
}

?>
