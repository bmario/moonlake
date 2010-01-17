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

abstract class Moonlake_Model_Model extends Moonlake_Model_MySQLModel {
    protected $values = array();
    protected $properities = array("obj_id" => "string");

    public function __construct() {
        parent::__construct();

        $this->values = $this->properities;

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

        $this->initTable();
    }

    public function __destruct() {
        parent::__destruct();
    }

    protected function initTable() {
        // is there a Table for this Model?
        $sql = 'CREATE TABLE IF NOT EXISTS '.$this->tableName()."\n";
        $sql .= '(`id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, ';
        foreach($this->values as $name => $type) {
            switch($type) {
                case 'int':
                    $type = 'INT(11)';
                    break;
                case 'string':
                case 'str':
                    $type = 'VARCHAR(255)';
                    break;
                case 'text':
                    $type = 'TEXT';
                    break;
                default:
                    $type = 'VARCHAR(255)';
            }

            $sql .= "`$name` $type NOT NULL, ";
        }

        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }

        $sql .= ')';

        $this->query($sql);
    }

    protected function tableName() {
       $classname = get_class($this);
       return '`Moonlake_'.$classname.'`';
    }

    /**
     * Return all Entries
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
     * Return one Entry.
     * Optional Parameter vor ID.
     */
    public function getEntry($id) {
        $sql = 'SELECT * FROM '.$this->tableName().' WHERE `id` = \''.$id.'\'';

        $qid = $this->query($sql);
        if($this->affected_rows($qid) == 1) {
            return $this->fetch($qid);
        }
        return false;
    }

    public function addEntry($args) {
        $sql = 'INSERT INTO '.$this->tableName().' ( `id`, ';

        $args['obj_id'] = md5($this->tableName()).'--'.md5(uniqid());

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

    public function removeEntry($id) {
        $sql = 'DELETE FROM '.$this->tableName()." WHERE `id` = '$id'";
        $this->query($sql);
    }

    public function findUniqueEntry($haystack, $needle) {
        $finds = $this->findEntry($haystack, $needle);
        return isset($finds[0]) ? $finds[0] : null;
    }

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
     * do not use this
     */

    public function findEntryByArray($haystacks, $needles) {
        $sql = 'SELECT * FROM '.$this->tableName().' WHERE';
        $valid = false;
        foreach($haystacks as $key => $haystack) {
            if(isset($this->values[$haystack])) {
                $sql .= " `$haystack` = '{$needles[$key]}' AND";
                $valid = true;
            }
        }
        if(!$valid) return array();
        $sql = substr($sql, 0, -4);
        $qid = $this->query($sql);

        $result = array();
        while($data = $this->fetch($qid)) {
           $result[] = $data;
        }
        return $result;
    }

    public function searchEntry($haystack, $needle) {
        if(isset($this->values[$haystack])) {

            $sql = 'SELECT * FROM '.$this->tableName()." WHERE `$haystack` LIKE '$needle'";
            $qid = $this->query($sql);

            $result = array();
            while($data = $this->fetch($qid)) {
                $result[] = $data;
            }
            return $result;
        }
        return array();

    }

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
