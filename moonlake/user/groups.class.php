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

final class Moonlake_User_Groups extends Moonlake_Model_Model {
    protected $properities = array("name" => "str");

    public function  __construct() {
        parent::__construct();
    }

    public function  __destruct() {
        parent::__destruct();
    }


    public function createGroup(Moonlake_User_Group $group) {
        $id = $this->addEntry($group->getAllProps());

        return $this->getGroup($id);
    }

    public function getGroup($id) {
        return $this->getGroupById($id);
    }


    public function getGroupById($id) {
        return $this->arrayToGroup($this->getEntry($id));
    }

    public function getGroupByName($name) {
        return $this->arrayToGroup($this->findUniqueEntry("name", $name));
    }

    public function deleteGroup($id) {
        return $this->removeEntry($id);
    }

    public function updateGroup(Moonlake_User_Group $group) {
        $this->editEntry($group->id, $group->getAllProps());
    }

    protected function arrayToGroup($group) {
        if(is_array($group)) {
            $g = new Moonlake_User_Group($group['id'], $group['name']);

            return $g;
        }
        return null;
    }
}

?>
