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
 * This class defines the model layout for the guestbook
 */
class guestbook_Model extends Moonlake_Model_Model {
    // this defines the name which is used to identify the model
    protected $area = "guestbook_Model";

    /*
     * this defines all fields for the model.
     * note that a field 'id' is created for you from the model.
     */
    protected $fields = array( "name" => Moonlake_Model_Backend::TYPE_STR,
                               "mail" => Moonlake_Model_Backend::TYPE_STR,
                               "message" => Moonlake_Model_Backend::TYPE_TXT);
}

?>