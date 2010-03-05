<?php
/*
 *       Copyright 2010 Mario Bielert <mario@moonlake.de>
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

/**
 * This class represents one result from Model requests.
 */
class Moonlake_Model_Result {

	private $__results__ = array();

	public function __set($name, $value) {
		$this->__results__[$name] = $value;
	}

	public function __get($name) {
		return isset($this->__results__[$name]) ? $this->__results__[$name] : null;
	}

	public function __isset($name) {
		return isset($this->__results__[$name]);
	}

	public function __unset($name) {
		if(isset($this->__results__[$name])) unset ($this->__results__[$name]);
	}
}

?>