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
 * This viewhelper is used to echo an escaped string.
 */
class escape_ViewHelper implements Moonlake_View_ViewHelper {
    public function execute(Moonlake_View_View $view, $arguments) {
        if(isset($arguments[0])) {
            echo htmlspecialchars($arguments[0], ENT_QUOTES, 'UTF-8');
        }
        else throw new Moonlake_Exception_View('There are to less arguments given to the escape_ViewHelper. There is excatly expected one argument.');
    }
}

?>
