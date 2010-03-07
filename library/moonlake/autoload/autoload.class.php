<?php

/*
 * copyright 2010 by Mario Bielert <mario@moonlake.de>
 * Moonlake Framework v2
 */

/*
 * This work is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any later
 * version.
 *
 * This work is distributed in the hope that it will be useful,
 * but without any warranty; without even the implied warranty of merchantability
 * or fitness for a particular purpose.
 * See version 2 and version 3 of the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

include_once('library/moonlake/autoload/autoloader.class.php');
include_once('library/moonlake/autoload/main.class.php');
include_once('library/moonlake/exception/moonlake.exception.php');
include_once('library/moonlake/exception/autoloader.exception.php');
include_once('library/moonlake/autoload/loader/autoloader.loader.php');

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

        foreach(self::$loader as $loader) {
            if($loader->includeClass($classname)) $loaded = true;
        }

        if(!$loaded){
            if (preg_match('/^[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*$/', $classname))
            {
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
                        throw new Moonlake_Exception_Autoloader("Could not find class '.$classname.'.\nThere are two common possibilities, In most cases this means, that for this classtype, there is no autoloader. To solve this, you must activate an approciate one, or write one on your own and activate it.", \''.$classname.'\', "");
                    }
                }');
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
     * Registers an autoloader, so it's used to solve classnames to paths
     *
     * @param Moonlake_Autoload_Autoloader $loader
     */
    public static function unregisterLoader(Moonlake_Autoload_Autoloader $loader) {
        if(in_array($loader, self::$loader)) self::$loader[] = $loader;
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
        include_once('library/moonlake/config/config.class.php');
        $alcfg = new Moonlake_Config_Config('autoload');


        foreach($alcfg->returnAll() as $loader) {
            try {
                $autoloader = new $loader();

            }
            catch(Moonlake_Exception_Autoloader $e) {
                throw new Moonlake_Exception_Autoloader("Could not register a particular autoloader class. Probably there is an mistake related to '{$e->classname}' in the configuration in 'config/autoload.config.php'. The loader is expected in the file {$e->classpath}.",$e->classname,$e->classpath);
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