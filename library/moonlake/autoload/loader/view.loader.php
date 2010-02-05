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

class View_Loader implements Moonlake_Autoload_Autoloader {

	/**
	 * Views are stored under application/view
	 * @see library/moonlake/autoload/Moonlake_Autoload_Autoloader#classPath($classname)
	 */
	public function classPath($classname) {
		$class = explode('_', $classname);
		try{
			if($class[1] == 'View') {
				$file = strtolower($class[0]);
				return "application/view/$file.view.php";
			}
		}
		catch(Exception $e) {}

		return '';
	}


	/**
	 * @see library/moonlake/autoload/Moonlake_Autoload_Autoloader#includeClass($classname)
	 */
	public function includeClass($classname) {
		$path = $this->classPath($classname);

		if(file_exists($path))
		{
			include_once($path);
			return class_exists($classname, false);
		}

		return false;
	}

}

?>