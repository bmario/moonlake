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

namespace de\Moonlake\Controller;
use de\Moonlake\Request\Request;
use de\Moonlake\Response\Response;

/**
 * This is the abstract class, every ActionController has to inherit.
 * 
 * Notice:
 * Every ActionController has the attributes ActionController::request and ActionController::response.
 * Use them instead of "echo"ing you contents! * 
 */
abstract class ActionController extends Controller {

    /*
     * protected reponse and request, so they are accessable in inherited classes 
     */
    protected $response;
    protected $request;
    
    /*
     * now give the contructer the response and request object, saves time fpr other things :)
     */
    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }
    
    /*
     * there has to be an index_Action() function in every controller
     */
    public abstract function index_Action();
}

?>
