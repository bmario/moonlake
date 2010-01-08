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
use de\Moonlake\Config\Config;

/**
 * this class handles lowlevel mysql connections 
 */
class MySQLModel {
    protected $hcon;

    protected $queries = array();

    /**
     * Constructor, opens mysql connection, read config from class Mysql_Config under config/mysql.conf.php
     */
    public function  __construct() {
        $config = new Config('mysql');

        $server = $config->hostname;
        $username = $config->username;
        $password = $config->password;
        $database = $config->database;

        $this->hcon = mysql_connect($server, $username, $password);
        mysql_select_db($database, $this->hcon);
    }

    /**
     * destructor, quits connection to mysql
     */
    public function  __destruct() {
        mysql_close($this->hcon);
    }

    /**
     * This methode queries the mysql database.
     * 
     * @param String the query SQL
     * @return int an id for this query, use this id in further functions, if there is aske for an query id
     */
    public function query($sql) {
        $qid = count($this->queries);

        $this->queries[$qid]['sql'] = $sql;
        $this->queries[$qid]['hres'] = mysql_query($sql, $this->hcon);
        $this->queries[$qid]['rows'] = mysql_affected_rows($this->hcon);
        $this->queries[$qid]['seek'] = 0;

        return $qid;
    }

    /**
     * this methode returns the id of the last inserted row
     * @return int id
     */
    public function insertId() {
        return mysql_insert_id($this->hcon);
    }

    /**
     * This method returns the count of affected rows by the query given by the id
     * @param int $qid
     * @return int count
     */
    public function affected_rows($qid) {
        return $this->queries[$qid]['rows'];
    }

    /**
     * Returns an associated array with values from the mysql database
     * @param Int query id
     * @return Array data || false
     */
    public function fetch($qid) {
        if($this->queries[$qid]['rows'] > $this->queries[$qid]['seek']) {
            $this->queries[$qid]['seek']++;
            return mysql_fetch_assoc($this->queries[$qid]['hres']);
        }
        return false;
    }
}

?>
