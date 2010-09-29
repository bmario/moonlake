<?php

/*
 *  Copyright 2010 Mario Bielert <mario@moonlake.de>
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

/**
 * This is a MySQL backend for the model. It is written quick and dirty.
 * You should not use it in real applciations.
 *
 * But actually this is the only class I can use on my webspace :(
 * ...so I have to use it through.
 */
class Moonlake_Model_MySQLBackend implements Moonlake_Model_Backend, Moonlake_Model_SupportsCondition {


    private $allowed_types = array( Moonlake_Model_ModelBackend::TYPE_INT,
                                    Moonlake_Model_ModelBackend::TYPE_STR,
                                    Moonlake_Model_ModelBackend::TYPE_TXT);
    private $con;

    /**
     * constructor for the backends
     * @param Moonlake_Model_Connector $con the connector which is to be used
     */
    public function __construct(Moonlake_Model_Connector $con) {
        $this->con = $con;
    }

    /**
     * creates an new entry and returns its id
     * @param: String $area the area
     * @param: String[] $fields an associative array with $field => $value for each field
     * @return: int id of the new entry
     */
    public function createEntry($area, $fields) {
        // build sql query
        $sql = 'INSERT INTO '.$this->tableName($area).' ( `id`';
        
        foreach($fields as $name => $value) {
            $sql .= ', `'.$name.'`';
        }
        
        $sql .= ') VALUES ( NULL';

        foreach($fields as $name => $value) {
            $sql .= ', \''.$value.'\'';
        }

        $sql .= ')';

        // execute query
        $qid = $this->con->query($sql);

        // get id
        $id = $this->con->last_inserted_id();

        // free query
        $this->con->free_query($qid);

        return $id;
    }

    /**
     * deletes the entry with the given id
     * @param String $area the area
     * @param int $id the new id
     */
    public function deleteEntry($area, $id) {
        // build query
        $sql = 'DELETE FROM '.$this->tableName($area)." WHERE `id` = '$id'";

        // execute and free query
        $this->con->free_query($this->con->query($sql));
    }

    /**
     * Updates a given entry with the contents of $fields
     * @param String $area the area
     * @param int $id the id
     * @param String[] $fields an associative array with $filedname => $new_field_content
     */
    public function updateEntry($area, $id, $fields) {
        // build query
        $sql = 'UPDATE '.$this->tableName($area).' SET ';

        foreach($fields as $key => $val) {
            $sql .= "`$key` = '$val', ";
        }

        if(substr($sql,-2) == ', ') {
            $sql = substr($sql,0,strlen($sql)-2);
        }

        $sql .= " WHERE `id` = '$id' LIMIT 1 ";

        // execute and free query
        $this->con->free_query($this->con->query($sql));
    }

    /**
     * returns all entries, which have in one of the given $fileds.
     * This should work like the following SQL Statement:
     * "SELECT * FROM `area` WHERE one_of($fields) LIKE '%$value%'
     * @param: String $area the area
     * @param: String[] $fields an array of fieldnames
     * @param: String $value the value to search for
     */
    public function findEntries($area, $fields, $value) {
        $sql = 'SELECT * FROM `'.$this->tableName($area).'` WHERE `'.$fields[0].'` LIKE \'%'.$value.'%\'';
        
        for($i=1; $i < count($fields); $i++) {
            $sql .= ' AND `'.$fields[$i].'` LIKE \'%'.$value.'%\'';
        }

        $sql .= ' ORDER BY `id` ASC';

        $id = $this->con->query($sql);

        $data = array();

        while($row = $this->con->fetch($id)) {
            $data[] = $row;
        }

        $this->con->free_query($id);

        return $data;

    }

    /**
     * Returns all entries which are in the given area
     * @param string $area the area
     */
    public function getAllEntries($area) {
        $sql = 'SELECT * FROM `'.$this->tableName($area).'` ORDER BY `id` ASC';
        $id = $this->con->query($sql);
        $data = array();

        while($row = $this->con->fetch($id)) {
            $data[] = $row;
        }

        $this->con->free_query($id);

        return $data;

    }

    /**
     * Returns all Entries that have all in the field $field the value $value
     * This should work like the following SQL Statement:
     * "SELECT * FROM `$area` WHERE `$field` = '$value'
     * @param: String $area the area
     * @param: String $field the name of the
     */
    public function getEntriesBy($area, $field, $value) {
        $sql = 'SELECT * FROM `'.$this->tableName($area).'` WHERE `'.$field.'` = \''.$id.'\''.' ORDER BY `id` ASC';
        $id = $this->con->query($sql);

        $data = array();

        while($row = $this->con->fetch($id)) {
            $data[] = $row;
        }

        $this->con->free_query($id);

        return $data;

    }

    /**
     * get an Entry by the given id
     * @param: String $area the area
     * @param: Int the id
     */
    public function getEntryById($area, $id) {
        $sql = 'SELECT * FROM `'.$this->tableName($area).'` WHERE `id` = \''.$id.'\'';
        $id = $this->con->query($sql);
        if($this->con->affected_rows($id) > 0) {
            $data = $this->con->fetch($id);
        }
        else $data = null;

        $this->con->free_query($id);
        
        return $data;
    }


    /**
     * initialize the given area.
     * That means stuff like creating the table and so on.
     * If an area is allready initialized, this should do nothing!
     * This is called everytime before a given area is used.
     * @param String $area the area
     * @param String $fields[] an associative array with $fieldname => $type
     */
    public function initArea($area, $fields) {
        $sql = 'CREATE TABLE IF NOT EXISTS `'.$this->tableName($area)."` ";
        $sql .= '( `id` INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY';
        foreach($fields as $name => $type) {
            if($this->isValidType($type)) {

                // FIXME there is no escape, could be a problem? on the other
                // hand, it comes from the class itself.

                if($type == self::TYPE_STR or $type == self::TYPE_TXT) {
                    // set charset und collate to utf8
                    $sql .= " ,`$name` $type CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL";
                }
                else {
                    // for INT we don't need a charset ;)
                    $sql .= " ,`$name` $type NOT NULL";
                }
            }
            else throw new Moonlake_Exception_ModelBackend("The given type for the field '$name' is not valid.\n");
        }

        $sql .= ' )';

        $this->con->free_query($this->con->query($sql));
    }

    /**
     * reinitialize the given area.
     * That means delete the area and initialize it with the new structure.
     * @param String $area the area
     * @param String $fields[] an associative array with $fieldname => $type
     */
    public function reinitArea($area, $fields) {
        $sql = "DROP TABLE IF EXISTS ".$this->tableName($area);
        $this->con->free_query($this->con->query($sql));

        $this->initArea($area, $fields);
    }
    
    /**
     * generates a tablename with the given area
     * @param String $area 
     */
    private function tableName($area) {
        return 'Moonlake_'.$area;
    }

    /**
     * Returns true, if the given type is in self::Allowed_Types
     * @param String $type the type of the field
     * @return boolean
     */
    private function isValidType($type) {
        return in_array($type, $this->allowed_types);
    }

    /**
     * Deletes all entries which fit the conditions
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @return int num of deletions
     */
    public function deleteEntriesByCondition($area, Moonlake_Model_Condition $cond) {
        $sql = 'DELETE FROM `'.$this->tableName($area).'`';

        // add conditions to SQL
        if($cond->hasConditions()) {
            $sql .= ' WHERE';

            $count = 0;

            foreach($cond->getAllIs() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);

                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` = '$val'";
                $count++;
            }

            foreach($cond->getAllLike() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);

                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` LIKE '%$val%'";
                $count++;
            }
        }
        else {
            // FIXME add an override for that, perhabs that could be useful?
            // uha, deleting all? !! WTF?
            throw new Moonlake_Exception_ModelBackend("Your using an empty condition together with the request to delete, is that really what you want? In fact, it does not seem to be a good idea. If you really want it anyways, you can use reinitArea().");
        }

        $qid = $this->con->query($sql);

        $count = $this->con->affected_rows($qid);

        $this->con->free_query($qid);

        return $count;
    }


    /**
     * This returns an array of results, which fulfill the condition.
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @return Moonlake_Model_Result[] the resultset
     */
    public function getEntriesByCondition($area, Moonlake_Model_Condition $cond) {
        $sql = 'SELECT * FROM `'.$this->tableName($area).'`';

        // add conditions to SQL
        if($cond->hasConditions()) {
            $sql .= ' WHERE';

            $count = 0;

            foreach($cond->getAllIs() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);

                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` = '$val'";
                $count++;
            }

            foreach($cond->getAllLike() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);
                
                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` LIKE '%$val%'";
                $count++;
            }
        }

        // add ordering to SQL
        if($cond->hasOrder()) {
            // get the field, which is to be ordered
            $field = mysql_escape_string($cond->getOrderField());

            /*
             * get the direction
             * don't need to be escaped, because only ASC and DESC are allowed!
             */
            $order = $cond->getOrderDirection();

            $sql .= " ORDER BY `$field` $order";
        }

        $qid = $this->con->query($sql);

        $results = array();

        while($result = $this->con->fetch($qid)) {
            $results[] = $result;
        }

        $this->con->free_query($qid);

        return $results;
    }
    
    
    /**
     * Update all entries which fit the conditions.
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @param String[] $fields an array with changes
     */
    public function updateEntriesByCondition($area, Moonlake_Model_Condition $cond, $fields) {
        $sql = 'UPDATE '.$this->tableName($area).' SET ';

        $count = 0;

        foreach($fields as $key => $val) {
            if($count++ > 0) $sql .= ', ';
            $sql .= "`$key` = '$val'";
        }

        // add conditions to SQL
        if($cond->hasConditions()) {
            $sql .= ' WHERE';

            $count = 0;

            foreach($cond->getAllIs() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);

                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` = '$val'";
                $count++;
            }

            foreach($cond->getAllLike() as $field => $val) {
                $field = mysql_escape_string($field);
                $val = mysql_escape_string($val);

                if($count > 0) $sql .= ' AND';
                $sql .= " `$field` LIKE '%$val%'";
                $count++;
            }
        }
        else {
            // FIXME add an override for that, perhabs that could be useful?
            // uha, updating all? !! WTF?
            throw new Moonlake_Exception_ModelBackend("Your using an empty condition together with the request to update entries. Which does not seem to be a good idea.");
        }

        $this->con->free_query($this->con->query($sql));
    }
}

?>
