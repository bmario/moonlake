<?php
/*
 *       Copyright 2010 Mario Bielert <mario@moonlake.de>
 *
 *       This program is free software; you can redistribute it and/or modify
 *       it under the terms of the GNU General Public License as published by
 *       the Free Software Foundation; either version 2 of the License, or
 *       (at your option) any later version.
 *
 *       This program is distributed in the hope that it will be useful,
 *       but WITHOUT ANY WARRANTY; without even the implied warranty of
 *       MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *       GNU General Public License for more details.
 *
 *       You should have received a copy of the GNU General Public License
 *       along with this program; if not, write to the Free Software
 *       Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *       MA 02110-1301, USA.
 */

/**
 * This class is for controller, which are embedded in views of actioncontroller.
 * They don't have an index_Action() until
 *
 * The do not have request or response objects!!!
 * Set parameters to every action, if you need one.
 */
class Moonlake_Controller_WidgetController {
	protected $view;

	public function __construct(Moonlake_View_View $view) {
		$this->view = $view;
	}

	public function execute($action, $arguments) {
		
		    if(method_exists($this, $action)) {
            try {
				call_user_func(array($this, $action), $arguments);
			}
			catch(Exception $e) {
				try{
					$this->error_Action();
				}
				catch(Exception $ee) {
					throw $e;
				}
			}
        }
        else {
			$this->error_Action();
	    }
		
	}
	
	public function error_Action() {
		throw new Moonlake_Exception_WidgetController("The given action wasn't found", get_class($this), '');
	}

}

?>