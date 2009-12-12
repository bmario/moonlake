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

class Moonlake_User_Memberships extends Moonlake_Model_Model {
    protected $properities = array("uid" => "str",
                                   "gid" => "str");

    public function  __construct() {
        parent::__construct();
    }

    public function  __destruct() {
        parent::__destruct();
    }

    public function joinGroup(Moonlake_User_Group $group, Moonlake_User_User $user) {
        if(!$this->isMemberOf($group, $user)) {
            $this->addEntry(array("uid" => $user->obj_id, "gid" => $group->obj_id));
            return true;
        }
        return false;
    }

    public function leaveGroup(Moonlake_User_Group $group, Moonlake_User_User $user) {
        $id = $this->isMemberOf($group, $user);
        if(is_numeric($id)) {
            return $this->removeEntry($id);
        }
        return false;
    }

    public function isMemberOf(Moonlake_User_Group $group, Moonlake_User_User $user) {
        $entries = $this->findEntry("uid", $user->obj_id);
        
        foreach($entries as $entry) {
            if($entry['gid'] == $group->obj_id) return $entry['id'];
        }
        return false;
    }

    public function getGroupsObjId(Moonlake_User_User $user) {
        $entries = $this->findEntry("uid", $user->obj_id);

        $groups = array();

        foreach($entries as $entry) {
            $groups[] = $entry['obj_id'];
        }

    }
}

?>
