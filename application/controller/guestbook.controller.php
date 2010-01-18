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

class guestbook_Controller extends Moonlake_Controller_ActionController {
    /**
      * Show all entries of the guestbook
      */
    public function index_Action(Moonlake_Request_Request $request, Moonlake_Response_Response $response) {
        $view = new guestbook_View();
        $model = new guestbook_Model();

        // load entries from Model:
        $entries = $model->getEntries();
        $entries = array_reverse($entries);
        // assign to index_View
        $view->index_View()->assign("entries", $entries);
        $view->index_View()->render($response);
    }

    /**
      * Create new entry in the Guestbook
      */
    public function newentry_Action(Moonlake_Request_Request $request, Moonlake_Response_Response $response) {
        // model instance
        $model = new guestbook_Model();
        // new entry

        $args = array();
        $args['name'] = $request->getParam("name");
        $args['mail'] = $request->getParam("mail");
        $args['message'] = $request->getParam("message");
        $model->addEntry($args);
        
        // view instance
        $view = new guestbook_View();
        // load entries from Model:
        $entries = $model->getEntries();
        $entries = array_reverse($entries);
        // assign to index_View
        $view->index_View()->assign("entries", $entries);
        // render index_View
        $view->index_View()->render($response);
    }
}

?>
