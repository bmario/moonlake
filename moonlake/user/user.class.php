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

class Moonlake_User_User extends Moonlake_User_Identity {
    private $id;
    private $name;
    private $passwort;

    public function __construct($id, $name, $passwort) {
        $this->id = $id;
        $this->name = $name;
        $this->passwort = $passwort;
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
            case "passwort":
                return $this->passwort;
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
        $props['password'] = $this->passwort;

        return $props;
    }

    public function authentificate($password) {
        return md5($password) == $this->passwort;
    }

    public function changePassword($oldpassword, $newpassword) {
        if($this->authentificate($oldpassword)) {
            $this->passwort = md5($newpassword);
            return true;
        }
        else {
            return false;
        }
    }
}

?>
