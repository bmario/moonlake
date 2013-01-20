<?php

/*
 *  Copyright 2010-2011 Mario Bielert <mario.bielert@googlemail.com>
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

class widget_ViewHelper implements Moonlake_View_ViewHelper {

    public function execute(Moonlake_View_View $view, $arguments) {
        if(isset($arguments[0])) $ctrl = $arguments[0].'_Controller';
        else throw new Moonlake_Exception_View('Not enought arguments given. The first parameter should be the name of the controller.');
        if(isset ($arguments[1])) $action = $arguments[1].'_Action';
        else throw new Moonlake_Exception_View('Not enought arguments given. The first parameter should be the name of the action.');

        $args = array();
        for($i=2; $i < count($arguments); $i++) {
            $args[] = $arguments[$i];
        }

        if(class_exists($ctrl) and is_subclass_of($ctrl, 'Moonlake_Controller_Widget')) {
            $c = new $ctrl($view);

            echo $c->execute($action, $args);
        }
        else throw new Moonlake_Exception_View('The controller '.$ctrl.' does not exists.');
    }
}

?>