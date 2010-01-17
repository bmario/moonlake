<?php

/*
 * copyright 2010 by Mario Bielert <mario@moonlake.de>
 * Moonlake Framework v2
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
 
include_once('moonlake/autoload/autoloader.class.php');
include_once('moonlake/exception/moonlake.exception.php');
include_once('moonlake/exception/autoloader.exception.php');
include_once('moonlake/autoload/loader/autoloader.loader.php');

class Moonlake_Autoload_Autoload {

	private static $loader = array();

	/**
	 * Handler for spl_autoload()
	 * 
	 * @param String $classname
	 */
	public static function loadClass($classname) {

		$filename = '';

		foreach(self::$loader as $loader) {
			$filename = $loader->classPath($classname);
			if($filename != '') break;
		}

		if($filename == '') throw new Moonlake_Exception_Autoloader("Could not find class $classname. In most cases this means, that for this classtype, there is no autoloader. To solve this, you must activate an approciate one, or write one on your own and activate it.", $classname, $filename);
		
		if(file_exists($filename)) {
			include_once($filename);
		}
		else throw new Moonlake_Exception_Autoloader("Could not find class $classname. In most cases this means, that the file storing the class is stored in the wrong place. It is expected under '$filename'.", $classname, $filename);


	}

	/**
	 * Registers an autoloader, so it's used to solve classnames to paths
	 * 
	 * @param Moonlake_Autoload_Autoloader $loader
	 */
	public static function registerLoader(Moonlake_Autoload_Autoloader $loader) {
		self::$loader[] = $loader;
	}

	public static function initAutoload() {

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