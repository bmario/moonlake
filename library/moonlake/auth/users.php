<?php

/*
 *      Copyright 2010 Mario Bielert <mario@moonlake.de>
 *
 *      This file is part of the Moonlake Framework.
 *
 *      The Moonlake Framework is free software: you can redistribute it and/or
 *      modify it under the terms of the GNU General Public License as published
 *      by the Free Software Foundation, either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      Foobar is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
 *
 */

class Moonlake_Auth_User {
    private $userid = null;
    private $model  = null;
    
    public function __construct($userid, Moonlake_Model_Model $model) {
        $this->userid = $userid;
        $this->model  = $model;
    }
    
    public function getId()
    {
        return $this->userid;
    }
    
    public function getLogin()
    {
        $data = $this->model->getEntryById($this->userid);
        return $data->login;
    }
    
    public function setLogin($name)
    {
        $this->model->updateEntry($this->userid, array('login' => $name));
    }
    
    public function getPassword()
    {
        $data = $this->model->getEntryById($this->userid);
        return $data->password;
    }
    
    public function setPassword($password)
    {
        $this->model->updateEntry($this->userid, array('password' => md5($password)));
    }
    
    public function getRoles()
    {
        $mb = $this->model->getBackend();
        $model = new Moonlake_Auth_UsersRolesModel($mb);
        
        $cond = new Moonlake_Model_Condition();
        $cond->is('user', $this->userid);
        
        return $model->getEntriesByCondition($cond);
    }
    
    public function addRole(Moonlake_Auth_Role $role)
    {
        $mb = $this->model->getBackend();
        $model = new Moonlake_Auth_UsersRolesModel($mb);
        
        $cond = new Moonlake_Model_Condition();
        $cond->is('user', $this->userid);
        $cond->is('role', $role->getId());
        
        if(!count($model->getEntriesByCondition($cond)))
        {
            $model->createEntry(array("user" => $this->userid, "role" => $role->getId()));
        }
    }
    
    public function delRole(Moonlake_Auth_Role $role)
    {
        $mb = $this->model->getBackend();
        $model = new Moonlake_Auth_UsersRolesModel($mb);
        
        $cond = new Moonlake_Model_Condition();
        $cond->is('user', $this->userid);
        $cond->is('role', $role->getId());

        $model->deleteEntriesByCondition($cond);
    }
}

class Moonlake_Auth_UsersModel extends Moonlake_Model_Model {
    protected $area = 'Auth_SubjectsData';
    protected $fields = array(
        "login"     => Moonlake_Model_Backend::TYPE_STR,
        "password"  => Moonlake_Model_Backend::TYPE_STR,
    );
}

class Moonlake_Auth_UsersRolesModel extends Moonlake_Model_Model {
    protected $area = 'Auth_UserRolesData';
    protected $fields = array(
        "user" => Moonlake_Model_Backend::TYPE_INT,
        "role" => Moonlake_Model_Backend::TYPE_INT
    );
}

/**
 * This class represents a subject.
 * A subject is the who in an access.
 */
class Moonlake_Auth_Users {

    private $model = null;
    private $session = null;
    
    public function __construct(Moonlake_Model_Backend $mb)
    {
        $this->model = new Moonlake_Auth_UsersModel($mb);

        $this->session = new Moonlake_Auth_Session();
    }
    
    public function userExists($id)
    {
        $user = $this->model->getEntryById($id);
        return $user !== null;
    }
    
    public function getUserById($id)
    {
        if(!$this->userExists($id)) throw new Moonlake_Exception_Auth("The user with id $id doesn't exists.");
        return new Moonlake_Auth_User($id, $this->model);
    }

    public function getUserByLogin($login)
    {
        $users = $this->model->getEntriesBy('login', $login);

        if($users == array()) {
            throw new Moonlake_Exception_Auth("The user with login $login doesn't exists.");
        }
        else {
            return new Moonlake_Auth_User($users[0]->id, $this->model);
        }
    }

    public function authentificateUser($login, $password)
    {
        try
        {
            $user = $this->getUserByLogin($login);
        }
        catch(Moonlake_Exception_Auth $e)
        {
            return false;
        }

        if($user->getPassword() == md5($password)) {
            $this->session->reattachToSession('moonlake_auth_user', $login);
            return true;
        }
        else return false;
    }

    public function isUserAuthentificated()
    {
        return $this->session->isAttachedToSession('moonlake_auth_user');
    }

    public function getAuthentificatedUser()
    {
        try
        {
            return $this->getUserByLogin($this->session->getAttachment('moonlake_auth_user'));
        }
        catch(Exception $e)
        {
            throw new Moonlake_Exception_AuthUsers ("There is no authentificated user.");
        }
    }
    
    public function createUser($login, $password)
    {
        $this->model->createEntry(array("login" => $login, "password" => md5($password)));
        
        return $this->getUserByLogin($login);
    }
}

?>
