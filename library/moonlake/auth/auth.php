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

class Moonlake_Auth_AuthModel extends Moonlake_Model_Model {
    protected $area = 'Auth_AuthData';
    protected $fields = array(
        "context"  =>  Moonlake_Model_Backend::TYPE_STR,
        "subject" =>  Moonlake_Model_Backend::TYPE_INT,
        "action"  =>  Moonlake_Model_Backend::TYPE_STR,
    );  
}

class Moonlake_Auth_Auth {

    private $model = null;
    
    public function __construct(Moonlake_Model_Backend $mb) {
        $this->model = new Moonlake_Auth_AuthModel($mb,"Moonlake");
    }

    public function hasUserAuthorization($context, Moonlake_Auth_User $user, $action) {
        foreach($user->getRoles() as $role)
        {
            if($this->hasRoleAuthorization($context, $role, $action))
                return true;
        }
        
        return false;
    }

    public function hasRoleAuthorization($context, Moonlake_Auth_Role $role, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $role->getId());
        $cond->is('action', $action);

        if(count($this->model->getEntriesByCondition($cond)))
            return true;
        else
            return false;
    }

    public function createAuthorizationForRole($context, Moonlake_Auth_Role $role, $action) {
        $fields = array(
            'context'  => $context,
            'subject' => $role->getId(),
            'action'  => $action,
        );

        $this->model->createEntry($fields);
    }

    public function deleteAuthorizationForRole($context, Moonlake_Auth_Role $role, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $role->getId());
        $cond->is('action', $action);

        $this->model->deleteEntriesByCondition($cond);
    }
}

?>