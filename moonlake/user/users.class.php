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

class Moonlake_User_Users extends Moonlake_Model_Model {
    protected $properities = array("username" => "str",
                                   "password" => "str");

    public function  __construct() {
        parent::__construct();
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function getUser($uid) {
        $user = $this->getEntry($uid);

        return $this->arrayToUser($user);
    }

    private function arrayToUser($user) {
        if(is_array($user)) {
            $u = new Moonlake_User_User($user['id'], $user['username'], $user['password']);

            foreach($user as $key => $val) {
                $u->$key = $val;
            }

            return $u;
        }
        return null;
    }

    private function userToArray(Moonlake_User_User $user) {
        $ret = array();
        foreach($this->values as $key => $val)
        {
            $ret[$key] = $user->$key;
        }
        return $ret;
    }

    public function addUser($username, $password) {
        return $this->addEntry(array('username' => $username, 'password' => md5($password) ));
    }

    public function getUserByName($name) {
        $user = $this->findUniqueEntry("username", $name);

        return $this->arrayToUser($user);
    }

    public function delUser($uid) {
        return $this->removeEntry($uid);
    }

    public function saveUser(Moonlake_User_User $user) {
        $u = $this->userToArray($user);
        $this->editEntry($user->uid, $u);
    }
}

?>
