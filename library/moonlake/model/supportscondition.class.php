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

interface Moonlake_Model_SupportsCondition {
    /**
     * This returns an array of results, which fulfill the condition.
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @return Moonlake_Model_Result[] the resultset
     */
    public function getEntriesByCondition($area, Moonlake_Model_Condition $cond);

    /**
     * Deletes all entries which fit the conditions
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @return int num of deletions
     */
    public function deleteEntriesByCondition($area, Moonlake_Model_Condition $cond);

    /**
     * Update all entries which fit the conditions.
     * @param String area the area
     * @param Moonlake_Model_Condition $cond
     * @param String[] $fields an array with changes
     */
    public function updateEntriesByCondition($area, Moonlake_Model_Condition $cond, $fields);
}

?>