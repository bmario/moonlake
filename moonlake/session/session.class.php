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

class Moonlake_Session_Session {
    static private $sid = null;

    public function __construct() {
        if(self::$sid === null) {
            session_start();
            self::$sid = session_id();
        }
    }

    public function issetParameter($name) {
        return isset($_SESSION[$name]);
    }

    public function storeParameter($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function loadParameter($name) {
        if($this->issetParameter($name)) {
            return $_SESSION[$name];
        }
        return null;
    }

    public function hasSession() {
        return $this->issetParameter('token');
    }

    public function startSession() {
        $this->storeParameter('token', uniqid());
    }

    public function endSession() {
        session_destroy();
        session_start();
    }
}

?>
