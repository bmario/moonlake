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

/**
 * This Viewhelper is for easy creating urls.
 */
class url_ViewHelper implements Moonlake_View_ViewHelper {

    public function execute(Moonlake_View_View $view, $arguments) {
        if(isset($arguments[0]) && isset($arguments[1])) {
            $ctrl = urlencode($arguments[0]);
            $action = urlencode($arguments[1]);
            echo "index.php?ctrl={$ctrl}&action={$action}";
        }
        else throw new Moonlake_Exception_View("There is missing an argument for the url_ViewHelper. A controller name and an action name is required.");
    }
}

?>