<?php

/*
 *  Copyright 2011 Mario Bielert <mario.bielert@googlemail.com>
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
 
class Moonlake_Exception_Auth extends Moonlake_Exception_Moonlake {
    public $controller;
    public $action;

    public function __construct($message) {
        $message = "Error in Auth Framework stack: \n$message";
        
        parent::__construct($message);
    }
    
}

?>