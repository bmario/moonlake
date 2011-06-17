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

class Moonlake_Auth_Role
{
    private $roleid = null;
    private $model  = null;
    
    public function __construct($id, Moonlake_Model_Model $model)
    {
        $this->roleid = $id;
        $this->model  = $model;
    }
    
    public function getId()
    {
        return $this->roleid;
    }
    
    public function getName()
    {
        $data = $this->model->getEntryById($this->roleid);
        return $data->name;
    }
    
    public function setName($name)
    {
        $this->model->updateEntry($this->roleid, array('name' => $name));
    }
}

class Moonlake_Auth_RolesModel extends Moonlake_Model_Model
{
    protected $area = "moonlake_auth_roles";
    protected $fields = array(
        "name" => Moonlake_Model_ModelBackend::TYPE_STR
    );    
}

class Moonlake_Auth_Roles
{
    private $model = null;
    
    public function __construct(Moonlake_Model_Backend $mb) {
        $this->model = new Moonlake_Auth_RolesModel($mb);
    }
    
    public function roleExists($id)
    {
        $role = $this->model->getEntryById($id);
        return $role !== null;
    }
    
    public function getRoleById($id)
    {
        if(!$this->roleExists($id)) throw new Moonlake_Exception_AuthRoles("The role with the id '$id' doesn't exist.");
        return new Moonlake_Auth_Role($id, $this->model);
    }

    public function getRoleByName($name)
    {
        $roles = $this->model->getEntriesBy('name', $name);
        if(!isset($roles[0])) throw new Moonlake_Exception_AuthRoles("The role with the name '$name' doesn't exist.");

        return new Moonlake_Auth_Role($roles[0]->id, $this->model);
    }
}

?>
