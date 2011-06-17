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
        "subject" =>  Moonlake_Model_Backend::TYPE_STR,
        "action"  =>  Moonlake_Model_Backend::TYPE_STR,
        "type"      =>  Moonlake_Model_Backend::TYPE_BOOL,
        "granted"   =>  Moonlake_Model_Backend::TYPE_BOOL
    );  
}

class Moonlake_Auth_Auth {

    private $model = null;
    
    public function __construct(Moonlake_Model_Backend $mb) {
        $this->model = new Moonlake_Auth_AuthModel($mb,"Moonlake");
    }

    public function hasUserAuthorization($context, $user, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $user);
        $cond->is('action', $action);
        $cond->is('type', 0);

        $datasets = $this->model->getEntriesByCondition($cond);
        if(isset($datasets[0]) and $datasets[0]->granted == 1) return true;
        return false;
    }

    public function hasRoleAuthorization($context, $role, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $role);
        $cond->is('action', $action);
        $cond->is('type', 1);

        $datasets = $this->model->getEntriesByCondition($cond);
        if(isset($datasets[0]) and $datasets[0]->granted == 1) return true;
        return false;
    }

    public function createAuthorizationForUser($context, $user, $action) {
        $fields = array(
            'context'  => $context,
            'subject' => $user,
            'action'  => $action,
            'type'      => '0',
            'granted'   => '1'
        );

        $this->model->createEntry($fields);
    }

    public function deleteAuthorizationForUser($context, $user, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $user);
        $cond->is('action', $action);
        $cond->is('type', 0);

        $this->model->deleteEntriesByCondition($cond);
    }

    public function createAuthorizationForRole($context, $role, $action) {
        $fields = array(
            'context'  => $context,
            'subject' => $role,
            'action'  => $action,
            'type'      => '1',
            'granted'   => '1'
        );

        $this->model->createEntry($fields);
    }

    public function deleteAuthorizationForRole($context, $role, $action) {
        $cond = new Moonlake_Model_Condition();
        $cond->is('context', $context);
        $cond->is('subject', $role);
        $cond->is('action', $action);
        $cond->is('type', 1);

        $this->model->deleteEntriesByCondition($cond);
    }
}

?>