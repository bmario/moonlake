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

class Exception_Loader extends Moonlake_Autoload_Autoloader {
    /**
     * @param String $classname
     * @see library/moonlake/autoload/Moonlake_Autoload_Autoloader#classPath($classname)
     */
    public function classPath($classname) {
        $class = explode('_', $classname);
        try{
            if(@$class[1] != 'Exception') return '';
            if(isset($class[3])) return '';
            if($class[0] != 'Moonlake') return '';

            $file = strtolower($class[2]);

            return "library/moonlake/exception/$file.php";
        }
        catch(Exception $e) {
            return '';
        }
    }

}

?>