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

class empty_Controller extends Moonlake_Controller_ActionController {
    public function index_Action() {
        $view = new empty_View();
        $sauth = new Moonlake_Session_Authentification();
        if($sauth->isAuthentificated()) {
            $user = $sauth->getAuthentificatedUser();
            $view->index_View()->assign("login", true);
            $view->index_View()->assign("username", $user->name);
        }
        else {
            $view->index_View()->assign("login", true);
        }
        $view->index_View()->render($this->response);

    }

    public function loginform_Action() {
        $view = new empty_View();

        $view->loginform_View()->render($this->response);
    }

    public function login_Action() {
        $view = new empty_View();

        $login = false;
        $session = new Moonlake_Session_Session();
        $session->startSession();
        $username = $this->request->getParam("name");
        $password = $this->request->getParam("password");

        $users = new Moonlake_User_Users();
        $user = $users->getUserByName($username);

        if($user) {
            if($user->authentificate($password)) {
                // user has authentificated
                $sauth = new Moonlake_Session_Authentification();
                $sauth->createAuthentification($user);
                $login = true;
                $view->login_View()->assign("username", $username);
            }
        }

        $view->login_View()->assign("login", $login);
        $view->login_View()->render($this->response);
    }
}

?>
