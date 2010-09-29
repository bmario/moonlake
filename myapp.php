<?php

/*
 *  Copyright 2010 Mario Bielert <mario@moonlake.de>
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
 * The Application class
 */
class MyApp extends Moonlake_Application_Application {

    // a list of allowed controllers
    protected $allowed_controller = array('main', 'guestbook');

    // the init methode
    public function init() {
        // use default response and request
        $this->response = new Moonlake_Response_HttpResponse();
        $this->request = new Moonlake_Request_HttpRequest();

        // the boring one :)
        $this->frontctrl = new Moonlake_Controller_Front($this);

        // use the controller here as defaults instead of index_Controller
        $this->frontctrl->setDefaultController('main');
    }
}

?>