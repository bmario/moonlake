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

class Moonlake_Model_MySQLiConnector implements Moonlake_Model_SQLConnector {

    private $config;
    private $mysqli;

    private $queries  = array();
    private $prepares = array();

    public function __construct(Moonlake_Config_Config $config) {
        $this->config = $config;
        $this->connect();
    }

    public function affected_rows($id) {
        if(!isset($this->queries[$id])) throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid query. This mostly means, that the query is freed before it's used");
        return $this->queries[$id]['rows'];
    }

    public function connect() {
        $config = $this->config;

        if(!isset($config->hostname) or
           !isset($config->username) or
           !isset($config->password) or
           !isset($config->database)) {
            throw new Moonlake_Exception_ModelConnector(
                'There is missing an option in the given config file.
Please make sure that the file '.$config->getFilePath().' exists
and it is set each of the following options:
hostname, username, password and database.');
        }
        
        $hostname = $config->hostname;
        $username = $config->username;
        $password = $config->password;
        $database = $config->database;
        
        $this->mysqli = new mysqli($hostname, $username, $password, $database);

        $errno = mysqli_connect_errno();
        if($errno) {
            // connection failed
            $error = mysqli_connect_error();
            throw new Moonlake_Exception_ModelConnector("Where was an error in the MySQL-Connection.\nMySQL Error: #$errno\n $error\n");

        }
    }
    public function disconnect() {
        $this->mysqli->close();
        $this->mysqli = null;
    }
    public function execute($id) {
        if(!isset($this->prepares[$id])) throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid prepared statement. This mostly means, that the statement is freed befor this call");

        for($i = 0; $i < count($this->prepares[$id]['types']); $i++) {
            $args[] = func_get_arg($i + 1);
        }
        $stmt = $this->prepares[$id]['stmt'];

        call_user_method_array('bind_param', $stmt, $args);
        $stmt->execute() or $this->error($this->prepares[$id]['sql']);

        // bind result byref to array
        call_user_func_array(array($stmt, "bind_result"), $byref_array_for_fields);
        // returns a copy of a value
        $copy = create_function('$a', 'return $a;');

        $results = array();
        while ($mysqli_stmt_object->fetch()) {
            // array_map will preserve keys when done here and this way
            $result = array_map($copy, $byref_array_for_fields);

            $mresult = new Moonlake_Model_Result();
            foreach($result as $key => $val) $mresult->$key = $val;

            $results[] = $mresult;

        }

        // create with this new query
        $qid = count($this->queries);

        $this->queries[$qid]['sql']        = $sql;
        $this->queries[$qid]['rows']    = count($results);
        $this->queries[$qid]['seek']    = 0;
        $this->queries[$qid]['result']    = $results;

        return $results;
    }

    public function fetch($id) {
        if(isset($this->queries[$id])) {
            if($this->queries[$qid]['rows'] > $this->queries[$qid]['seek']) {
                $result = $this->queries[$qid]['result'][$this->queries[$qid]['seek']++];
                
                return $result;
            }
            else return false;
        }
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid query. This mostly means, that the query is freed before it's used");
    }

    public function free_query($id) {
        if(isset($this->queries[$id])) unset($this->queries[$id]);
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid query. This mostly means, that the query is freed before it's used");
    }

    public function free_stmt($id) {
        if(isset($this->prepares[$id])) unset($this->prepares[$id]);
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid prepared statement. This mostly means, that the statement is freed before this call");
    }

    public function last_inserted_id() {
        return $this->mysqli->insert_id;
    }

    public function prepare($sql, $types) {
        $id = count($this->prepares);
        $this->prepares[$id]['stmt']    = $this->mysqli->prepare($sql);
        $this->prepares[$id]['types']    = $types;
        $this->prepares[$id]['sql']        = $sql;

        return $id;
    }

    public function query($sql) {
        $id = count($this->queries);
        $this->queries[$id]['sql']        = $sql;
        $this->queries[$id]['rows']        = $this->mysqli->affected_rows;
        $this->queries[$id]['seek']        = 0;

        $result     = $this->mysqli->query() or $this->error($sql);
        $seek     = 0;
        $rows     = $this->queries[$id]['rows'];
        $results = array();

        // fetch results
        while($rows > $seek++) {
            $result = $this->queries[$qid]['result']->fetch_array(MYSQLI_ASSOC);

            // transform result to Moonlake_Model_Result
            $mresult = new Moonlake_Model_Result();
            foreach($result as $key => $val) $mresult->$key = $val;

            $results[] = $mresult;
        }

        $this->queries[$id]['result'] = $results;

        return $id;
    }

    public function error($query = "") {
        $errno = mysqli_errno();
        $error = mysqli_error();
        $query = $query == '' ? '' : $query."\n";
        throw new Moonlake_Exception_ModelConnector("Where was an error in the MySQL-Connection.\nMySQL Error: #$errno\n $error\n$query");
    }

}

?>