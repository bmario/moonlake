<?php

/*
 * copyright 2009 2010 by Mario Bielert <mario@moonlake.de>
 *
 * This work is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any later version.
 *
 * This work is distributed in the hope that it will be useful,
 * but without any warranty; without even the implied warranty of merchantability
 * or fitness for a particular purpose.
 * See version 2 and version 3 of the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */


/**
 * Abstract class for every AutoloaderHelper classes.
 */
interface Moonlake_Autoload_Autoloader {

    /**
     * This methode returns the Path to file, where the given class is stored or nothing.
     *
     * @param String $classname
     * @return String Classpath or ''
     */
    public function classPath($classname);

    /**
     * This method includes the given class.
     * If the resolved class exists and is loaded, then it should return true,
     * in case of any trouble, it should return false.
     *
     * @param String $classname
     * @return boolean - the success of include
     */
    public function includeClass($classname);

}

?>