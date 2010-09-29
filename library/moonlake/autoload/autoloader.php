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
 * Abstract class for every AutoloaderHelper classes.
 */
abstract class Moonlake_Autoload_Autoloader {

    /**
     * This methode returns the Path to file, where the given class is stored or nothing.
     *
     * @param String $classname
     * @return String Classpath or ''
     */
    abstract public function classPath($classname);

    /**
     * This method includes the given class.
     * If the resolved class exists and is loaded, then it should return true,
     * in case of any trouble, it should return false.
     *
     * @param String $classname
     * @return boolean - the success of include
     */
    public function includeClass($classname) {
        // get relative path to root
        $path = $this->classPath($classname);

        // could class be resolved?
        if($path == '') {
            return false;
        }

        try {
		    // try to include
            include_once($path);

            // now test if the class or interface exists and if yes, we were successfully.
            return class_exists($classname, false) or interface_exists($classname, false);
        }
        catch(Exception $e) {
		    // if something went wrong, then the include wasn't successful.
			return false;
        }
    }
}

?>