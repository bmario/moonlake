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

final class Moonlake_User_Users extends Moonlake_Model_Model {
    protected $properities = array("name" => "str",
                                   "password" => "str");

    public function  __construct() {
        parent::__construct();
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function getUser($id) {
        $user = $this->getEntry($id);

        return $this->arrayToUser($user);
    }

    public function createUser($name, $password) {
        $user = new Moonlake_User_User("0", $name, $password);
        $id = $this->addEntry($user->getAllProps());

        $user = $this->getUserById($id);

        return $user;
    }

    public function getUserById($id) {
        return $this->getUser($id);
    }

    public function getUserByName($name) {
        $user = $this->findUniqueEntry("name", $name);

        return $this->arrayToUser($user);
    }

    public function deleteUser($uid) {
        return $this->removeEntry($uid);
    }

    public function updateUser(Moonlake_User_User $user) {
        $this->editEntry($user->id, $user->getAllProps());
    }
    
    protected function arrayToUser($user) {
        if(!is_array($user)) return null;
        if(!isset($user['id'])) return null;
        if(!isset($user['name'])) return null;
        if(!isset($user['password'])) return null;

        return new Moonlake_User_User($user['id'], $user['name'], $user['password']);
    }
}

?>
