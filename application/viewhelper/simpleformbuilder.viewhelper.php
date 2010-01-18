<?php
/*
 *       Copyright 2009 Mario Bielert <mario@moonlake.de>
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
class simpleFormBuilder_ViewHelper implements Moonlake_View_ViewHelper {
    public static function execute($args) {
        $link = "<form action=\"?\" methode=\"post\">";
        $link .= "<input type=\"hidden\" name=\"ctrl\" value=\"{$args[0]}\">";
        $link .= "<input type=\"hidden\" name=\"action\" value=\"{$args[1]}\">";
        if(!isset($args[2])) $args[2] = array();
        foreach($args[2] as $key => $val)
        {
            $link .= "<input type=\"hidden\" name=\"{$key}\" value=\"{$val}\">";
        }
        return $link;
    }
}
?>