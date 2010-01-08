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

namespace de\Moonlake\Controller;
use de\Moonlake\Request\Request;
use de\Moonlake\Response\Response;
/*
 * This class allows to create a chain of PrePostcontrollers
 */
class ChainCommand implements Command {
    private $controllers = array();
    
    /*
     * fullfill the interface
     */
    public function run(Request $request, Response $response) {
        foreach($this->controllers as $cmd) {
            $cmd->run($request,$response);
        }
    }
    
    /*
     * This methode adds a PrePostController to the chain.
     * The controllers will be called in the same order, they are added.
     * 
     * @param Moonlake_Controller_PrePostController the instanze of a controller
     */
    public function addCommand(Command $ctrl) {
        $this->controllers[] = $ctrl;        
    }
}