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
 * This is a quiet simple and slow MySQL Connector. It is provided because it is
 * very simple.
 */

class Moonlake_Model_MySQLConnector implements Moonlake_Model_SQLConnector {
    protected $hcon;
    protected $config = null;

    protected $queries = array();
    protected $prepares = array();

    public function  __construct($config) {
        $this->config = $config;
        $this->connect();
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

        $server   = $config->hostname;
        $username = $config->username;
        $password = $config->password;
        $database = $config->database;

        $this->hcon = @mysql_connect($server, $username, $password) or ($this->error());
        @mysql_select_db($database, $this->hcon) or ($this->error());
        @mysql_set_charset('UTF8', $this->hcon);
    }

    public function  disconnect() {
        @mysql_close($this->hcon);
    }

    public function prepare($sql) {
        $pid = $this->generate_id();

        $this->prepares[$pid]['sql'] = explode('?',$sql);

        return $pid;
    }

    public function execute($id, $types) {
        $args = func_get_args();
        $argc = func_num_args();

        if(isset($this->prepares[$id])) {
            $parts = $this->prepares[$id]['sql'];

            if(strlen($types) == count($parts) - 1) {
                $count = count($parts) - 1;
            }
            else throw new Moonlake_Exception_ModelConnector("The count of wildcards in the query and the count of given types aren't equal.");

            if($argc != 1 + $count) {
                $given = $argc - 1;
                throw new Moonlake_Exception_ModelConnector("The count of arguments are wrong. Expected were {$count} arguments, but {$given} given.");
            }

            $sql = '';
            $i = 2;
            foreach($parts as $part) {
                if($i == count($parts)) $sql .= $part;
                else $sql .= $part.mysql_escape_string($args[$i]);
                $i++;

            }
            return $this->query($sql);
        }
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid prepared statement. This mostly means, that the statement is freed befor this call");
    }

    public function query($sql) {
        $qid = $this->generate_id();

        $this->queries[$qid]['sql']  = $sql;
        $this->queries[$qid]['hres'] = @mysql_query($sql, $this->hcon) or ($this->error($sql));
        $this->queries[$qid]['rows'] = @mysql_affected_rows($this->hcon);
        $this->queries[$qid]['seek'] = 0;

        return $qid;
    }

    private function generate_id() {
        static $last_id=0;
        return $last_id++;
    }
    
    public function last_inserted_id() {
        return @mysql_insert_id($this->hcon) or die($this->error());
    }

    public function affected_rows($qid) {
        return $this->queries[$qid]['rows'];
    }

    public function fetch($qid) {
        if(!isset($this->queries[$qid]))
                throw new Moonlake_Exception_ModelConnector(
                "The given id doesn't represent a valid query. This mostly means, that the query is freed before it's used");

        if($this->queries[$qid]['rows'] > $this->queries[$qid]['seek']) {
            $this->queries[$qid]['seek']++;
            $data = @mysql_fetch_assoc($this->queries[$qid]['hres']);
            if(mysql_errno($this->hcon)) $this->error($this->queries[$qid]['sql']);
            $result = new Moonlake_Model_Result();
            foreach($data as $key => $val) $result->$key = $val;

            $result->seal();
            
            return $result;
        }
        else return null;
    }

    public function error($query = '') {
        $errno = mysql_errno();
        $error = mysql_error();
        $query = $query != '' ? "Query: $query\n" : '';
        throw new Moonlake_Exception_ModelConnector("Where was an error in the MySQL-Connection.\nNumber: $errno\nMessage: $error\n$query");
    }

    public function free_query($id) {
        if(isset($this->queries[$id]))unset($this->queries[$id]);
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid query. This mostly means, that the query is freed before it's used");
    }

    public function free_stmt($id) {
        if(isset($this->prepares[$id])) unset($this->prepares[$id]);
        else throw new Moonlake_Exception_ModelConnector("The given id doesn't represent a valid prepared statement. This mostly means, that the statement is freed before this call");
    }

    public function __destruct() {
        $this->disconnect();
    }
}

?>
