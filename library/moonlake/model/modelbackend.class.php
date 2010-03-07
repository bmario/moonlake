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
 * This declares an interface for classes which are used as an backend for models.
 * All functions have as the first parameter the name of the selected space,
 * where the entries are taken from. In terms of SQL these are the tables.
 */
interface Moonlake_Model_ModelBackend {
    const TYPE_TXT = 'TEXT';
    const TYPE_INT = 'INT(11)';
    const TYPE_STR = 'VARCHAR(255)';

    /**
     * constructor for the backends
     * @param Moonlake_Model_Connector $con the connector which is to be used
     */
    public function __construct(Moonlake_Model_Connector $con);

    /**
     * Returns all entries which are in the given area
     * @param string $area the area
     */
    public function getAllEntries($area);

    /**
     * get an Entry by the given id
     * @param: String $area the area
     * @param: Int the id
     */
    public function getEntryById($area, $id);

    /**
     * Returns all Entries that have all in the field $field the value $value
     * This should work like the following SQL Statement:
     * "SELECT * FROM `$area` WHERE `$field` = '$value'
     * @param: String $area the area
     * @param: String $field the name of the
     */
    public function getEntriesBy($area, $field, $value);


    /**
     * returns all entries, which have in one of the given $fileds.
     * This should work like the following SQL Statement:
     * "SELECT * FROM `area` WHERE one_of($fields) LIKE '%$value%'
     * @param: String $area the area
     * @param: String[] $fields an array of fieldnames
     * @param: String $value the value to search for
     */
    public function findEntries($area, $fields, $value);

    /**
     * creates an new entry and returns its id
     * @param: String $area the area
     * @param: String[] $fields an associative array with $field => $value for each field
     * @return: int id of the new entry
     */
    public function createEntry($area, $fields);

    /**
     * deletes the entry with the given id
     * @param String $area the area
     * @param int $id the new id
     */
    public function deleteEntry($area, $id);

    /**
     * Updates a given entry with the contents of $fields
     * @param String $area the area
     * @param int $id the id
     * @param String[] $fields an associative array with $filedname => $new_field_content
     */
    public function updateEntry($area, $id, $fields);

    /**
     * initialize the given area.
     * That means stuff like creating the table and so on.
     * If an area is allready initialized, this should do nothing!
     * This is called everytime before a given area is used.
     * @param String $area the area
     * @param String $fields[] an associative array with $fieldname => $type
     */
    public function initArea($area, $fields);

    /**
     * reinitialize the given area.
     * That means delete the area and initialize it with the new structure.
     * @param String $area the area
     * @param String $fields[] an associative array with $fieldname => $type
     */
    public function reinitArea($area, $fields);


}

?>