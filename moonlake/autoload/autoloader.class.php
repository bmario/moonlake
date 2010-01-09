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

namespace de\Moonlake\Autoload;

/**
 * This class bundles some methode for autoloading classes, interfaces and templates
 * 
 * @author Mario Bielert
 */
class Autoloader
{
    public static $loaded_classes = array();
    /**
     * This methode includes needed classes dynamically.
     * You have nothing to do. It's registered to autoload.
     *
     * For further information about paths in moonlakefw have a look to the Wiki.
     *
     * @param String classname
     * @return boolen success
     */
    public static function loadClass($name) {
        /*
         * resolve path to Class
         */
        $path = self::getClassPath($name);

        // for debugging reasons, add all loaded classes to the array
        self::$loaded_classes[] = $name.": ".$path;

        // include file, or not
        if(file_exists($path)) {
            include_once($path);
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * required for switch to namespace
     * to switch from big classnames to namespaces, the following two methods must be reimplemented.
     */
    
    /**
     * This method is only used by the class Moonlake_View_Templates to resolve template paths.
     * Normally you shouldn't need this function.
     * 
     * @param String name of the template
     * @return String path of the template
     */
    public static function getTemplatePath($name) {
        $path = strtolower($name);
        $path = 'template/'.$path.'.xml';

        return $path;
    }

   /**
    * This method resolves classnames.
    * Only private.
    * 
    * @param unknown_type $classname
    * @return unknown_type
    */
   private static function getClassPath($classname) {
        
        /*
         * a viewhelper?
         */
        if(substr($classname, -11) == '_ViewHelper') {
            $path = strtolower(substr($classname,0, strlen($classname)-11));
            return 'viewhelper/'.$path.'.viewhelper.php';
        }
        
        /*
         * a controller?
         */
        if(substr($classname, -11) == '_Controller') {
            $path = strtolower(substr($classname,0, strlen($classname)-11));
            return 'controller/'.$path.'.controller.php';
        }

        /*
         * a command?
         */
        if(substr($classname, -8) == '_Command') {
            $path = strtolower(substr($classname,0, strlen($classname)-8));
            return 'command/'.$path.'.command.php';
        }
        
        
        /*
         * a model?
         */
        if(substr($classname, -6) == '_Model') {
            $path = strtolower(substr($classname,0, strlen($classname)-6));
            return 'model/'.$path.'.model.php';
        }

        /*
         * a macro?
         */
        if(substr($classname, -6) == '_Macro') {
            $path = strtolower(substr($classname,0, strlen($classname)-6));
            return 'macro/'.$path.'.macro.php';
        }

        /*
         * a view?
         */
        if(substr($classname, -5) == '_View') {
            $path = strtolower(substr($classname,0, strlen($classname)-5));
            return 'view/'.$path.'.view.php';
        }
        
        /*
         * a config file?
         */
        if(substr($classname, -7) == '_Config') {
            $path = strtolower(substr($classname,0, strlen($classname)-7));
            return 'config/'.$path.'.config.php';
        }
        
        /*
         * some class of the framework itself?
         */
        if(substr($classname,0, 12) == 'de\\Moonlake\\') {
            $path = strtolower(substr($classname, 12));
            $path = 'moonlake/'.str_replace('\\','/',$path).'.class.php';

            return $path;
        }


    }
}

/*
 * register our autoload methode :) 
 */
spl_autoload_register(array('de\\Moonlake\\Autoload\\Autoloader', 'loadClass'));

?>