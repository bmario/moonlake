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
 * This class represents one result from Model requests.
 */
class Moonlake_Model_Result {

    private $__results__ = array();
    private $__sealed__  = false;

    public function __set($name, $value) {
        if($this->__sealed__) throw new Moonlake_Exception_Model('Moonlake_Model_Result is sealed. This means that every try to change a value is prohibited.');
        $this->__results__[$name] = $value;
    }

    public function __get($name) {
        return isset($this->__results__[$name]) ? $this->__results__[$name] : null;
    }

    public function __isset($name) {
        return isset($this->__results__[$name]);
    }

    public function __unset($name) {
        if($this->__sealed__) throw new Moonlake_Exception_Model('Moonlake_Model_Result is sealed. This means that every try to change a value is prohibited.');
        if(isset($this->__results__[$name])) unset ($this->__results__[$name]);
    }
    
    public function seal()
    {
        $this->__sealed__ = true;
    }
    
    public function isSealed()
    {
        return $this->__sealed__;
    }
}

?>