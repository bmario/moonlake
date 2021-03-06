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
 * This interface is for validation classes.
 * They provide an easy interface to check if some input is a valid value.
 */
interface Moonlake_Validation_Validator {
    /**
     * Returns true if the input value is a valid value.
     * @param any $value the input value
     * @return boolean
     */
    public function isInputValid($value);

    /**
     * returns true if any value can be casted into a valid value.
     * otherwise false
     * @return boolean
     */
    public function castable();

    /**
     * returns a casted value, or null
     * @param any $value the value
     */
    public function cast($value);

    /**
     * This checks if the input value is valid and returns then the input.
     * Or if the values are castabel, the casted values are returned.
     * Otherwise null
     *
     * USE THIS!!!
     */
    public function validate($value);
}

?>