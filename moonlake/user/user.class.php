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

class Moonlake_User_User {
    private $uid;
    private $username;
    private $passwort;
    private $props = array();

    public function __construct($uid, $username, $passwort) {
        $this->uid = $uid;
        $this->username = $username;
        $this->passwort = $passwort;
    }

    public function __set($key, $val) {
        switch($key) {
            case "uid":
            case "username":
            case "passwort":
                return false;
                break;
            default:
                $this->props[$key] = $val;
                return true;
                break;
        }
    }

    public function __get($key) {
        switch($key) {
            case "uid":
                return $this->uid;
                break;
            case "username":
                return $this->username;
                break;
            case "passwort":
                return $this->passwort;
                break;
            default:
                return isset($this->props[$key]) ? $this->props[$key] : null;
                break;
        }
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
