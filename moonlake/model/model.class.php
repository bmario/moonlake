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

namespace de\Moonlake\Model;

/**
 * This class abstracts the mysql interface.
 * 
 * Now you have the choice of using simple interface.
 * Additional you can use the lowlevel mysql methods.
 * 
 * Usage:
 * extend this class. make sure you call parental __destruct() and __construct()
 * create an protected property called "properties" as an associated array.
 * write for every datafield you need an entry to this array with one of the following types:
 * 
 *  - string (or str) for short string, like names (max 255 characters) TODO is 255 to less?
 *  - int for integers (max 11 numbers) TODO is 11 to less?
 *  - short for small integers (max 4 numbers)
 *  - text for long texts, like postings
 * 
 * e.g.
 * 
 * protected $properties = array("name" => "str", "age" => "str", "message" => "text");
 * 
 * that's all.
 * 
 * (Some detailed information, the database table name will be "Moonlake_" + Classname
 * Also an primary key with the name id will allways be created) 
 */
abstract class Model extends MySQLModel {
    protected $values = array(); //this array contains all datafield definitions stated in the heritage path
    
    /**
     * This array contains all datafield definitions for this class, extended classes can (and should) define their own.
     * (Do not care about the values stored in the parent classes. They will automatically applied, but you should take 
     * care, that you don't use an identifier more than once. In this case, the one nearest to your extended class will 
     * be used.) 
     * 
     * Write for every datafield you need an entry to this array with one of the following types:
     * 
     *  - string (or str) for short string, like names (max 255 characters) TODO is 255 to less?
     *  - int for integers (max 11 numbers) TODO is 11 to less?
     *  - short for small integers (max 4 numbers)
     *  - text for long texts, like postings
     * 
     * e.g.
     * protected $properties = array("name" => "str", "age" => "str", "message" => "text"); 
     * 
     * ATTENTION: This attribute has to be protected, do NOT set it as private! 
     * 
     * @var array
     * 
     */
    protected $properities = array('id' => 'int_prim');

    /**
     * constructor
     * @return unknown_type
     */
    public function __construct() {
        /*
         * allways call parent
         */
        parent::__construct();

        /*
         * prepare $values
         */
        $this->values = $this->properities;

        /*
         * little magic :)
         * this methode will be called in the last inherited child, 
         * so we walk throw all parent classes and fill the $values array with the according
         * $properities array.
         */
        $parent = $this;
        while($parent = get_parent_class($parent)) {
            $vars = get_class_vars($parent);
            $props = isset($vars['properities']) ? $vars['properities'] : array();
            foreach($props as $key => $val) {
                if(!isset($this->values[$key])) {
                    $this->values[$key] = $val;
                }
            }
        }

        /*
         * mysql table initen
         */
        $this->initTable();
    }

    /*
     * destructor, call parent's one
     */
    public function __destruct() {
        parent::__destruct();
    }

    /**
     * This method parses the $values array to a SQL query to initialize the table.
     * this also create the table if it's called first time.
     */
    private function initTable() {
        /*
         * is there a Table for this Model?
         */
        
        /*
         * create query
         */
        $sql = 'CREATE TABLE IF NOT EXISTS '.$this->tableName()."\n";

        foreach($this->values as $name => $type) {
            switch($type) {
                /*
                 * new type, only once allowed and will be set in this class (have a look at $properities)
                 * you must not use this. 
                 */
                case 'int_prim':
                    $sql .= "(`$name` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, ";

                /*
                 * interger type
                 */
                case 'int':
                    $sql .= "`$name` INT(11) NOT NULL, ";
                    break;

                /*
                 * short integer type (max 4 numbers)
                 */
                case 'short':
                    $sql .= "`$name` INT(4) NOT NULL, ";
                    break;
                    
                    
                /*
                 * textblob type
                 */
                case 'text':
                    $sql .= "`$name` TEXT NOT NULL, ";
                    break;
                    
                /*
                 * string and default type (because it takes more or less everything :) )
                 */
                case 'string':
                case 'str':
                default:
                    $sql .= "`$name` VARCHAR(255) NOT NULL, ";
            }
        }

        /*
         * some chars missing, some are to much
         */
        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }
        $sql .= ')';

        /*
         * submit query
         */
        $this->query($sql);
    }

    /**
     * Returns the name of the table.
     * Depends on classname.
     * 
     * @return String tablename
     */
    protected function tableName() {
       $classname = get_class($this);
       return '`Moonlake_'.$classname.'`';
    }

    /**
     * This methode returns ALL entries from this model
     * @return Array data
     */
    public function getEntries() {
        $sql = 'SELECT * FROM '.$this->tableName();

        $qid = $this->query($sql);
        $result = array();
        while($data = $this->fetch($qid)) {
            $result[] = $data;
        }

        return $result;
    }

    /**
     * Returns the datarow to the given id
     * @param int id
     * @return Array data
     */
    public function getEntry($id) {
        $sql = 'SELECT * FROM '.$this->tableName().' WHERE `id` = \''.$id.'\'';

        $qid = $this->query($sql);
        if($this->affected_rows($qid) == 1) {
            return $this->fetch($qid);
        }
        return false;
    }

    /**
     * Creates a new entry with the values from $args
     * @param Array args
     * @return Int id of the new entry
     */
    public function addEntry($args) {
        $sql = 'INSERT INTO '.$this->tableName().' ( `id`, ';

        foreach($args as $key => $val) {
            if(isset($this->values[$key])) {
                $sql .= "`$key`, ";
            }
        }

        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }

        $sql .= ') VALUES ( NULL, ';

        foreach($args as $key => $val) {
            if(isset($this->values[$key])) {
                $sql .= "'$val', ";
            }
        }

        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }

        $sql .=')';

        $this->query($sql);

        return $this->insertId();
    }

    /**
     * Deletes an entry given by id
     * @param int $id
     */
    public function removeEntry($id) {
        $sql = 'DELETE FROM '.$this->tableName()." WHERE `id` = '$id'";
        $this->query($sql);
    }

    /**
     * Finds an entry where haystack equals needle
     * @param var $haystack
     * @param var $needle
     * @return array data
     */
    public function findUniqueEntry($haystack, $needle) {
        $finds = $this->findEntry($haystack, $needle);
        return isset($finds[0]) ? $finds[0] : null;
    }

    /**
     * Finds all entries where haystack equals needle
     * @param var $haystack
     * @param var $needle
     * @return ArrayArray data
     */
    public function findEntry($haystack, $needle) {
        if(isset($this->values[$haystack])) {

            $sql = 'SELECT * FROM '.$this->tableName()." WHERE `$haystack` = '$needle'";
            $qid = $this->query($sql);

            $result = array();
            while($data = $this->fetch($qid)) {
                $result[] = $data;
            }
            return $result;
        }
        return array();
    }

    /**
     * Changes an entry given by id withthe values of changes
     * @param int $id
     * @param array $changes
     */
    public function editEntry($id, $changes) {
        $sql = 'UPDATE '.$this->tableName().' SET ';

        foreach($changes as $key => $val) {
            if(isset($this->values[$key])) {
                $sql .= "`$key` = '$val', ";
            }
        }

        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }

        $sql .= " WHERE `id` = '$id' LIMIT 1 ";

        return $this->affected_rows($this->query($sql));
    }
}

?>
