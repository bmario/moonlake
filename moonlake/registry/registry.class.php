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

class Moonlake_Registry_Registry {
    private $registred=array();
    private static $instance = null;

    public static function getInstance() {
        if(self::$instance === null) {
            self::$instance = new Moonlake_Registry_Registry();
        }

        return self::$instance;
    }

    protected function __construct(){
    }

    private function __clone(){
    }

    public function store($name, Moonlake_Registry_Registrable $object) {
        if(!isset($this->registred[$name])) {
            $this->registred[$name] = $object;
            return;
        }
        $eventDispatcher = Moonlake_Event_EventDispatcher::getInstance();
        $eventDispatcher->triggerEvent('error_sys_crit', $this, "There is allready an object stored as $name in the registry.");
    }

    public function unstore($name) {
        if(!isset($this->registred[$name])) {
            unset($this->registred[$name]);
            return;
        }
        $eventDispatcher = Moonlake_Event_EventDispatcher::getInstance();
        $eventDispatcher->triggerEvent('error_sys_crit', $this, "There is no object stored as $name in the registry.");
    }

    public function load($name) {
        if(isset($this->registred[$name])) {
            return $this->registred[$name];
        }
        return null;
        $eventDispatcher = Moonlake_Event_EventDispatcher::getInstance();
        $eventDispatcher->triggerEvent('error_sys_crit', $this, "There is no object stored as $name in the registry.");
    }
}

?>