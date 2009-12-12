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

class Moonlake_Session_Authentification {
    private $session;

    public function __construct() {
        $this->session = new Moonlake_Session_Session();
    }

    public function isAuthentificated() {
        return $this->session->loadParameter('__user_id') !== null;
    }

    public function getAuthentificatedUser() {
        $id = (int) base64_decode($this->session->loadParameter('__user_id'));
        
        $users = new Moonlake_User_Users();
        $user = $users->getUser($id);

        return $user;
    }

    public function createAuthentification(Moonlake_User_User $user) {
        $this->session->startSession();
        $this->session->storeParameter('__user_id', base64_encode($user->id));
    }

    public function deleteAuthentification() {
        $this->session->storeParameter('__user_id', '');
    }
}

?>
