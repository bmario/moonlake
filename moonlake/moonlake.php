<?php

/* 
 * (c) 2009 by Mario Bielert <mario@moonlake.de>
 * Moonlake - Framework
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


include('moonlake/autoload/autoloader.class.php');

$event = Moonlake_Event_EventDispatcher::getInstance();
$error = new Moonlake_Error_Error();
$event->registerHandler("ERROR_*", $error);

?>