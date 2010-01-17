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

abstract class Moonlake_View_View {

    protected $views=array();

    protected function get_TemplateView($name) {
        if(!isset($this->views[$name])) {
            $this->views[$name] = new Moonlake_View_TemplateView($name);
        }
        return $this->views[$name];
    }

    public function __call($name, $args) {
        $tempname = get_class($this);
        $tempname = substr($tempname, 0, strlen($tempname)-5);
        $tempname .= '_'.substr($name, 0, strlen($name)-5);

        return $this->get_TemplateView($tempname);
    }
}

?>
