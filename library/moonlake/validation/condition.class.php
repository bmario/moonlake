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

class Moonlake_Validation_Condition {

	private $eq;
	private $eq_set = false;

	private $neq = array();

	private $validators = array();

	public function equal($val) {
		if($this->eq_set) throw new Moonlake_Exception_Validation('There is allready an equal condition set. This is usually not intended to reset this.');
		if(in_array($val, $this->neq)) throw new Moonlake_Exception_Validation('Try to define contrary equal and not equal condition.');

		$this->eq = $val;
		$this->eq_set = true;
		return $this;
	}

	public function is_equal_set() {
		if($this->is_equal_set()) {
			if($this->eq === $val) throw new Moonlake_Exception_Validation('Try to define contrary equal and not equal condition.');
		}
		return $this->eq_set;
	}

	public function not_equal($val) {
		$this->neq[] = $val;
		return $this;
	}

	public function valid(Moonlake_Validation_Validator $valid) {
		$this->validators[]= $valid;
		return $this;
	}

	public function isValid($input) {
		if($this->is_equal_set()) {
			// compare to equal condition
			if($this->eq !== $input) return false;
		}

		foreach($this->neq as $neq) {
			// compare to nt equal conditions
			if($input === $neq) return false;
		}

		foreach($this->validators as $vaid) {
			// validated with validators
			if(!$vaid->isIputValid($input)) return false;
		}

		return true;
	}

	public function reset() {
		$this->eq_set = false;
		$this->neq = array();
		$this->validators = array();

		return $this;
	}
}

?>
