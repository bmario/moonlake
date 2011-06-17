<?php

/*
 *  Copyright 2009 2010 Mario Bielert <mario@moonlake.de>
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
 * This function wraps the session managment.
 *
 * Cause of its design, it is save to create many instances of it.
 */
class Moonlake_Auth_Session {
    /**
     * The constructor.
     */
    public function __construct() {
        if(session_id() == '')
            session_start();
    }

    /**
     * This methode closes the session. This means that every session data is
     * destroyed. After the Session is closed, it will start a new session.
     *
     * ATTENTION: Be VERY careful with it, because ALL session data is destroyed
     * It is more likely, that you use unattachFromSession() instead of this!
     */
    public function closeSession() {
        session_destroy();
    }

    /**
     * This methode returns the session id. But be careful with this id!
     * @return string the session id
     */
    public static function getSessionId() {
        return session_id();
    }

    /**
     * This methode stores a value under the given name in the session.
     * @param <string> $name
     * @param <var> $value
     */
    public function attachToSession($name, $value) {
        global $_SESSION;
        
        if(isset($_SESSION[$name])) throw new Moonlake_Exception_AuthSession("The given name is allready in use.");
        
        $_SESSION[$name] = $value;
    }

    /**
     * This methode stores a value under the given name, but in difference to
     * attacheToSession, it overwrites old values.
     * @param <string> $name
     * @param <var> $value
     */
    public function reattachToSession($name, $value) {
        global $_SESSION;
        
        $_SESSION[$name] = $value;
    }

    /**
     * This methode clears the specified value from the session.
     * @param <string> $name
     */
    public function unattachFromSession($name) {
        global $_SESSION;
        
        if(!isset($_SESSION[$name])) throw new Moonlake_Exception_AuthSession("The given name is not attached to the session.");

        unset($_SESSION[$name]);
    }

    /**
     * This methode returns a bolean, whether the given name is stored or not.
     * @param <type> $name
     * @return <boolean>
     */
    public function isAttachedToSession($name) {
        global $_SESSION;
        
        return isset($_SESSION[$name]);
    }

    /**
     * This methode returns the value for he given name.
     * @param <string> $name
     * @return <var>
     */
    public function getAttachment($name) {
        global $_SESSION;
        
        if(!isset($_SESSION[$name])) throw new Moonlake_Exception_AuthSession("The given name is not attached to the session.");

        return $_SESSION[$name];
    }
}

?>