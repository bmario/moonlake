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
 * This class is used with modelbackends, which implements SupportsCondition
 */
class Moonlake_Model_Condition {

    private $is                = array();
    private $like            = array();
    private $orderdirection = null;
    private $orderfield        = null;

    /**
     * This method defines a "is" condition. This means, the given field must
     * be exactly the given value, to fit this.
     * @param String $field the name of the field
     * @param any $value the value, which the field is compared with.
     * @return Moonlake_Model_Condition the object itself
     */
    public function is($field, $value) {
        $this->is[$field] = $value;
        return $this;
    }

    /**
     * This method returns an array containing all "is" conditions.
     * The association is "fieldname" => "value to compare with".
     * @return array with all "is" conditions
     */
    public function getAllIs() {
        return $this->is;
    }

    /**
     * This method defines a "like" condition.
     * This means the given field contains the value given.
     * @param String $field the fieldname
     * @param String $value the vlue to compare with
     * @return Moonlake_Model_Condition the object itself
     */
    public function like($field, $value) {
        $this->like[$field] = $value;
        return $this;
    }

    /**
     * This methode returns an array containing all "like" conditions.
     * The association is "fieldname" => "value"
     * @return array with all "ike" conditions
     */
    public function getAllLike() {
        return $this->like;
    }

    /**
     * This method defines a order condition. This means the result will
     * be ordered by the field. Cause of problems with multiple order conditions
     * and their order there will be only one order possible, multiple defines
     * overwrites old one.
     * The value of order defines if the order will be ascending or descending.
     * Also note that every other value than 'DESC' for the order parameter will
     * be treated as 'ASC'.
     * @param String $field the field name
     * @param String $order set the direction of odering. default: ASC
     * @return Moonlake_Model_Condition the object itself
     */
    public final function orderby($field, $order = 'ASC') {
        $order = $order == 'DESC' ? 'DESC' : 'ASC';

        $this->orderdirection    = $order;
        $this->orderfield        = $field;
        return $this;
    }

    /**
     * these two methode returns the field and the direction of ordering
     * or null, if nothing is set.
     */
    public function getOrderField() {
        return $this->orderfield;
    }
    public function getOrderDirection() {
        return $this->orderdirection;
    }

    /**
     * returns true if there is a 'is' or a 'like' condition set
     * @return boolean
     */
    public function hasConditions() {
        return count($this->is) + count($this->like) > 0 ? true : false;
    }

    /**
     * returns true if there is set an order
     * @return boolean
     */
    public function hasOrder() {
        return $this->orderdirection === null ? false : true;
    }
}

?>