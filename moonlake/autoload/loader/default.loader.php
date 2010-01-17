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

class Default_Loader implements Moonlake_Autoload_Autoloader {
	public function classPath($classname) {
		$class = explode('_', $classname);
		if($class[0] != 'Moonlake') {
			return '';
		}
		
		try{
			$package = strtolower($class[1]);
			$file = strtolower($class[2]); 
			return "moonlake/$package/$file.class.php";
		}
		catch(Exception $e) {
			return '';
		}
		
	}
}

?>