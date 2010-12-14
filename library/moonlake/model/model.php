<?php

/*
 *  Copyright 2009 2010 Mario Bielert <mario@moonlake.de>
 *
 *  This file is part of the Moonlake Framework.
 *
 *  The Moonlake Framework is free software: you can redistribute it
 *  and/or modify it under the terms of the GNU General Public License
 *  as published by the Free Software Foundation, either version 3 of
 *  the License, or (at your option) any later version.
 *
 *  The Moonlake Framework is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with the Moonlake Framework.
 *  If not, see <http://www.gnu.org/licenses/>.
 */

abstract class Moonlake_Model_Model {

    protected $area = null;
    protected $fields = null;

    protected $mb;

    public function  __construct(Moonlake_Model_Backend $mb) {
        if($this->area === null) throw new Moonlake_Exception_Model('The area was not set to a valid value.');
        if($this->fields === null) throw new Moonlake_Exception_Model('The fields were not set to a valid value.');
        $this->mb = $mb;
        $mb->initArea($this->area, $this->fields);
    }

    /**
     * Returns all entries which are in the given area
     */
    public function getAllEntries() {
        return $this->mb->getAllEntries($this->area);
    }

    /**
     * get an Entry by the given id
     * @param: Int the id
     */
    public function getEntryById($id) {
        return $this->mb->getEntryById($this->area, $id);
    }

    /**
     * Returns all Entries that have all in the field $field the value $value
     * This should work like the following SQL Statement:
     * "SELECT * FROM `$area` WHERE `$field` = '$value'
     * @param: String $field the name of the
     */
    public function getEntriesBy($field, $value) {
        return $this->mb->getEntriesBy($this->area, $field, $value);
    }


    /**
     * returns all entries, which have in one of the given $fields.
     * This should work like the following SQL Statement:
     * "SELECT * FROM `area` WHERE one_of($fields) LIKE '%$value%'
     * @param: String[] $fields an array of fieldnames
     * @param: String $value the value to search for
     */
    public function findEntries($fields, $value) {
        return $this->mb->findEntries($this->area, $fields, $value);
    }

    /**
     * creates an new entry and returns its id
     * @param: String $area the area
     * @param: String[] $fields an associative array with $field => $value for each field
     * @return: int id of the new entry
     */
    public function createEntry($fields) {
        return $this->mb->createEntry($this->area, $fields);
    }

    /**
     * deletes the entry with the given id
     * @param String $area the area
     * @param int $id the new id
     */
    public function deleteEntry($id) {
        return $this->mb->deleteEntry($this->area, $id);
    }

    /**
     * Updates a given entry with the contents of $fields
     * @param String $area the area
     * @param int $id the id
     * @param String[] $fields an associative array with $filedname => $new_field_content
     */
    public function updateEntry($id, $fields) {
        return $this->mb->updateEntry($this->area, $id, $fields);
    }

    public function deleteEntriesByCondition(Moonlake_Model_Condition $cond) {
        return $this->mb->deleteEntriesByCondition($this->area, $cond);
    }

    public function getEntriesByCondition(Moonlake_Model_Condition $cond) {
        return $this->mb->getEntriesByCondition($this->area, $cond);
    }

    public function updateEntriesByCondition(Moonlake_Model_Condition $cond, $fields) {
        return $this->mb->updateEntriesByCondition($this->area, $cond, $fields);
    }

    /**
     * This function returns an almost unique identifier for the given id.
     * This function is used together with e.g. the auth classes.
     * @param int $id the id
     * @return unique identifier
     */
    public function getObjectID($id) {
        return md5($this->area.$id);
    }

}

?>
