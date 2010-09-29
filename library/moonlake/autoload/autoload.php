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

include_once('library/moonlake/autoload/autoloader.php');
include_once('library/moonlake/exception/moonlake.php');
include_once('library/moonlake/exception/autoloader.php');
include_once('library/moonlake/autoload/loader/autoloader.php');

/**
 * This class provides a handler for autoloading.
 * It uses other classes, called autoloader, which are implementing the autoloader
 * interface.
 */
class Moonlake_Autoload_Autoload {

    private static $loader = array();

    /**
     * Handler for spl_autoload()
     *
     * @param String $classname
     */
    public static function loadClass($classname) {

        $loaded = false;

        // try every loader which is registered, if it can load the given class
        foreach(self::$loader as $loader) {
            $loaded |= $loader->includeClass($classname);
        }

        // else create a class with the given name and let it throw an
        // exception, if it is used.
        if(!$loaded){
            // check if the name is valid
            if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $classname))
            {
                // use eval to create the class on the fly
                eval('class '.$classname.'
                {
                    public function __construct() {
                        $this->throwException();
                    }

                    public static function __callstatic($m, $args) {
                        self::throwException();
                    }

                    static public function throwException()
                    {
                        throw new Moonlake_Exception_Autoloader("Could not find class '.$classname.'.\nThere are two common possibilities, In most cases this means, that for this classtype, there is no autoloader. To solve this, you must activate an approciate one, or write one on your own and activate it.\nLoaded classloaders are:\n\n"'.implode('\n', self::listLoaders()).');
                    }
                }');
                }
                $errorclass = new '.$classname.'();');
            }
        }

    }

    /**
     * Registers an autoloader, so it's used to solve classnames to paths
     *
     * @param Moonlake_Autoload_Autoloader $loader
     */
    public static function registerLoader(Moonlake_Autoload_Autoloader $loader) {
        if(!in_array($loader, self::$loader)) self::$loader[] = $loader;
    }

    /**
     * Unregisters a given loader, so it's not used anymore for laoding classes.
     *
     * FIXME: should use a id or anything
     *
     * @param Moonlake_Autoload_Autoloader $loader
     */
    public static function unregisterLoader(Moonlake_Autoload_Autoloader $loader) {
        for($a = 0; $a < count(self::$loader); $a++) {
            if(self::$loader[$a] === $loader) unset(self::$loader[$a]);
        }
    }

    /**
     * This method initializes the autoloader stack
     * Therefore it registers every autoloader, which is given in
     * config/autoload.config.php.
     */
    public static function initAutoload() {

        // register tha whole autoload stack
        spl_autoload_register(array('Moonlake_Autoload_Autoload', 'loadClass'), true);

        // registers the autoloader loader
        Moonlake_Autoload_Autoload::registerLoader(new Autoloader_Loader());

        // load config
        include_once('library/moonlake/config/config.php');
        $alcfg = new Moonlake_Config_Config('autoload');


        foreach($alcfg->returnAll() as $loader) {
            try {
                $autoloader = new $loader();

            }
            catch(Moonlake_Exception_Autoloader $e) {
                throw new Moonlake_Exception_Autoloader("Could not register a particular autoloader class. Probably there is an mistake related to '{$e->classname}' in the configuration in 'config/autoload.php'. The loader is expected in the file {$e->classpath}.",$e->classname,$e->classpath);
            }

            Moonlake_Autoload_Autoload::registerLoader($autoloader);
        }
    }

    /**
     * Returns an array containing the Classnames of loaded autoloaders.
     */
    public static function listLoaders() {
        $result = array();
        foreach(self::$loader as $loader) {
            $result[] = get_class($loader);
        }

        return $result;
    }
}

?>