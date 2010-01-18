<?php

/* 
 * copyright 2009 2010 by Mario Bielert <mario@moonlake.de>
 * Moonlake - Framework
 */

/*
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
	 * @param string $classname
	 */
	public function classPath($classname);

}

/*

class Moonlake_Autoload_Autoloader
{
    //**
     * includes a needed class, 
     * @param <type> $name
     * @return <type> 
    // 
    public static function loadClass($name) {
        $path = self::getPath($name);

        try {
            include_once($path);
            return $path;
        }
        catch (Exception $e) {
            echo("The file '$path' containing requested class '$name' could not be load.");
            return false;
        }

    }

    public static function loadInterface($name) {
        return self::loadClass($name);
    }

    private static function getPath($name) {
        if(substr($name,0, 9) == 'Moonlake_') {
            $path = strtolower($name);
            $path = str_replace('_','/',$path).'.class.php';

            return $path;
        }
        if(substr($name, -11) == '_ViewHelper') {
            $path = strtolower(substr($name,0, strlen($name)-11));
            return 'viewhelper/'.$path.'.viewhelper.php';
        }
        if(substr($name, -11) == '_Controller') {
            $path = strtolower(substr($name,0, strlen($name)-11));
            return 'controller/'.$path.'.controller.php';
        }
        if(substr($name, -6) == '_Model') {
            $path = strtolower(substr($name,0, strlen($name)-6));
            return 'model/'.$path.'.model.php';
        }
        if(substr($name, -5) == '_View') {
            $path = strtolower(substr($name,0, strlen($name)-5));
            return 'view/'.$path.'.view.php';
        }
        if(substr($name, -7) == '_Config') {
            $path = strtolower(substr($name,0, strlen($name)-7));
            return 'config/'.$path.'.config.php';
        }
        $path = strtolower($name);
        return 'library/'.str_replace('_','/',$path).'.class.php';

    }

    public static function getTemplatePath($name) {
            $path = strtolower($name);
            $path = 'template/'.$path.'.template.php';

            return $path;
    }

}*/


?>