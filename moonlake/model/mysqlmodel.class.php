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

class Moonlake_Model_MySQLModel {
    protected static $hcon=null;

    protected static $cons = 0;

    protected $queries = array();

    public function  __construct() {
        if(self::$hcon === null) {
            $config = new Mysql_Config();

            $server = $config->hostname;
            $username = $config->username;
            $password = $config->password;
            $database = $config->database;

            $this->hcon = mysql_connect($server, $username, $password);
            mysql_select_db($database, $this->hcon);
        }
        self::$cons++;
    }

    public function  __destruct() {
        if(self::$cons == 1) mysql_close($this->hcon);
    }

    public function query($sql) {
        $qid = count($this->queries);

        $this->queries[$qid]['sql'] = $sql;
        $this->queries[$qid]['hres'] = mysql_query($sql, $this->hcon);
        $this->queries[$qid]['rows'] = mysql_affected_rows($this->hcon);
        $this->queries[$qid]['seek'] = 0;

        return $qid;
    }

    public function insertId() {
        return mysql_insert_id($this->hcon);
    }

    public function affected_rows($qid) {
        return $this->queries[$qid]['rows'];
    }

    public function fetch($qid) {
        if($this->queries[$qid]['rows'] > $this->queries[$qid]['seek']) {
            $this->queries[$qid]['seek']++;
            return mysql_fetch_assoc($this->queries[$qid]['hres']);
        }
        return false;
    }
}

?>
