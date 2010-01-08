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

class Moonlake_Event_EventDispatcher implements Moonlake_Registry_Registrable
{
    private static $instance = null;
    private $handler = array();

    public static function getInstance()
    {
        if(self::$instance === null)
        {
            self::$instance = new Moonlake_Event_EventDispatcher();
        }

        return self::$instance;
    }

    protected function __construct(){
    }

    private function __clone(){
    }

    public function registerHandler($event, Moonlake_Event_EventHandler $callback)
    {
        if(!isset($this->handler[$event]))
        {
            $this->handler[$event] = array();
        }
        foreach($this->handler[$event] as $registered)
        {
            if($registered === $callback)
            {
                return;
            }
        }
        $this->handler[$event][] = $callback;
    }

    public function unregisterHandler($event, Moonlake_Event_EventHandler $callback)
    {
        foreach($this->handler[$event] as $id =>$registered)
        {
            if($registered === $callback)
            {
                unset($this->handler[$event][$id]);
            }
        }
    }

    public function triggerEvent($name, $context = null, $info = null)
    {
        $event = new Moonlake_Event_Event($name, $context, $info);
        $matches = $this->findMatches($name);
        foreach($matches as $match) {
            foreach($this->handler[$match] as $handler)
            {
                $handler->handleEvent($event);
                if($event->isCancelled())
                {
                    break;
                }
            }
        }
        return $event;
    }

    private function findMatches($name) {
        $matches = array();
        foreach($this->handler as $event => $handlers) {
            if($name == $event) {
                $matches[] = $event;
            }
            else {
                if(stristr($event, '*') and stripos($event, '*')<=strlen($name)) {
                        if(substr($name, 0, stripos($event, '*')) == substr($event, 0, stripos($event, '*'))) {
                        $matches[] = $event;
                    }
                }
            }
        }
        return $matches;
    }

}

?>