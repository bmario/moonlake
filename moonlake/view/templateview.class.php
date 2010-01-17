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

class Moonlake_View_TemplateView {
    private $__name;
    private $__assigns =array();

    public function  __construct($name) {
        $this->__name = $name;
    }

    public function assign($name, $value) {
        $this->__assigns[$name] = $value;
    }

    public function __get($name) {
        if(isset($this->__assigns[$name])) {
            return $this->__assigns[$name];
        }
        else return "";
    }

    public function __call($name, $args) {
        $classname = $name.'_ViewHelper';
        if(class_exists($classname)) {
            return call_user_func(array($classname, "execute"), $args);
        }
        else return "";
    }

    public function render($response) {
        ob_start();
        $path = Moonlake_Autoload_Autoloader::getTemplatePath($this->__name);
        if(file_exists($path)) include($path);
        else echo "The template {$this->__name} was not found.";
        $response->write(ob_get_clean());
    }
}

?>
