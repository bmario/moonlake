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
 * This interface is for all connectors to a SQL capable backend.
 */
interface Moonlake_Model_SQLConnector extends Moonlake_Model_Connector {

    /**
     * establishes a connection to a sql server
     */
    public function connect();

    /**
     * disconnect from a sql server
     */
    public function disconnect();

    /**
     * Executes the given query
     * @param String $sql the query
     * @return returns an id for handling the query
     */
    public function query($sql);

    /**
     * returns the id of the last insertion
     */
    public function last_inserted_id();

    /**
     * returns the count of affected rows by the given query
     * @param id $id id of the query
     */
    public function affected_rows($id);

    /**
     * This prepares a statement so the execution will be much faster
     * Placeholder for variables are ?
     * @param String $sql the steatement with placeholders
     * @param String the types of the wildcards. i-int, d-float, b-blob, s-other
     * @return id $id an id for the prepared statement
     */
    public function prepare($sql, $types);

    /**
     * This executes the prepared statement with the given id
     * @param id $id
     * @return id an id to a query, which is usalbe with fetch()
     */
    public function execute($id);

    /**
     * Returns one dataset from the resultset of the query with $id
     * @param id $id the id which was given from query()
     * @result String[] an associative array with the dataset
     */
    public function fetch($id);

    /**
     * Free the given query
     * @param id $id
     */
    public function free_query($id);

    /**
     * Free the given preparation
     */
    public function free_stmt($id);

}

?>
