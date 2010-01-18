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

/**
 * Possible actions are:
 * 1 - read
 * 2 - write
 * 4 - delete
 * 8 - create
 */

class Moonlake_User_Authorizations extends Moonlake_Model_Model {
    protected $properities = array('object_id' => 'str',
                                   'allowed_actions' => 'int',
                                   'group_id' => 'str');

    public function  __construct() {
        parent::__construct();
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function addAuth($obj_id, $actions, Moonlake_User_Group $group) {
        return $this->addEntry(array('obj_id' => $obj_id, 'allowed_actions' => $actions, 'group_id' => $group->obj_id));
    }

    public function addAuthForTable($obj_id, $actions, Moonlake_User_Group $group) {
        $obj_id = split("--", $obj_id);
        $obj_id = $obj_id[0];
        return $this->addAuth($obj_id, $actions, $group->obj_id);
    }

    protected function getRight($obj_id, Moonlake_User_Group $group) {
        $entries = $this->findEntry('object_id', $obj_id);
        foreach($entries as $entry) {
            if($entry['group_id'] == $group->obj_id) return $entry['allowed_actions'];
        }
        return 0;
    }

    protected function setRight($obj_id, $action, Moonlake_User_Group $group) {
        $entries = $this->findEntry('object_id', $obj_id);
        $id = false;
        foreach($entries as $entry) {
            if($entry['group_id'] == $group->obj_id) $id = $entry['id'];
        }
        if(!$id) return $this->addAuth($obj_id, $action, $group);
        return $this->editEntry($id, array('allowed_actions' => $action));
    }

    public function grantRight($obj_id, $action, Moonlake_User_Group $group) {
        return $this->setRight($obj_id, $this->setRightMask($this->getRight($obj_id, $group), $action), $group);
    }

    public function grantRightForTable($obj_id, $action, de_Moonlake_User_Group $group) {
        $obj_id = split("--", $obj_id);
        $obj_id = $obj_id[0];

        return $this->setRight($obj_id, $this->setRightMask($this->getRight($obj_id, $group), $action), $group);
    }

    public function isAllowed($obj_id, $action, Moonlake_User_User $user) {
        $members = new de_Moonlake_User_Memberships();
        foreach($members->getGroupsObjId($user) as $obj_id) {
            $entry = $this->findUniqueEntry('object_id', $obj_id);
            if($entry !== null) {
                if($this->hasRight($entry['allowed_actions'], $action)) {
                    return true;
                }
            }
            $obj_id2 = split("--", $obj_id);
            $entry = $this->findUniqueEntry('object_id', $obj_id2[0]);
            if($entry !== null) {
                if($this->hasRight($entry['allowed_actions'], $action)) {
                    return true;
                }
            }
        }
        return false;
    }

    protected function hasRight($rights, $action) {
        return $rights & $action == $action;
    }

    protected function setRightMask($rights, $action) {
        return $rights | $action;
    }

    protected function unsetRightMask($rights, $action) {
        return $rights & ~$action;
    }
}

?>