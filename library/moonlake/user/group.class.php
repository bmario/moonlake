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

class Moonlake_User_Group extends Moonlake_User_Identity {
    private $id;
    private $name;

    public function __construct($id, $name) {
        $this->id = $id;
        $this->name = $name;
    }

    public function __set($key, $val) {
        return false;
    }

    public function __get($key) {
        switch($key) {
            case "id":
                return $this->id;
                break;
            case "name":
                return $this->name;
                break;
           default:
                return null;
                break;
        }
    }

    public function getAllProps() {
        $props = array();
        $props['id'] = $this->id;
        $props['name'] = $this->name;

        return $props;
    }
}

?>
