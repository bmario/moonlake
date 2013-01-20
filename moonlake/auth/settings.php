<?php

/*
 *  Copyright 2011 Mario Bielert <mario.bielert@googlemail.com>
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

class Moonlake_Auth_UserSettingsModel extends Moonlake_Model_Model
{
    protected $area = "Auth_SettingsData";
    protected $fields = array(
        'userid' => Moonlake_Model_Backend::TYPE_INT,
        'key'    => Moonlake_Model_Backend::TYPE_STR,
        'value'  => Moonlake_Model_Backend::TYPE_TXT
    );
}

/**
 * This class is an easy interface to store any user specific settings
 */
class Moonlake_Auth_Settings
{
    private $model = null;
    private $user  = null;

    public function __construct(Moonlake_Model_Backend $mb, Moonlake_Auth_User $user = null) {
        $users       = new Moonlake_Auth_Users($mb);
        
        if($user === null)
	        $this->user  = $users->getAuthentificatedUser();
	    else
	    	$this->user = $user;    
        $this->model = new Moonlake_Auth_UserSettingsModel($mb);
    }
    
    public function getSetting($key)
    {
        $cond = new Moonlake_Model_Condition('AND');
        
        $cond->is('userid', $this->user->getId());
        $cond->is('key', $key);
        
        $data = $this->model->getEntriesByCondition($cond);
        
        if(isset($data[0]))
            return $data[0]->value;
        else
            throw new Moonlake_Exception_Auth("The given option '$key' does not exists for the authentificated user.");
    }
    
    public function setSetting($key, $value)
    {
        $cond = new Moonlake_Model_Condition('AND');
        
        $cond->is('userid', $this->user->getId());
        $cond->is('key', $key);

        $data = $this->model->getEntriesByCondition($cond);
        
        if(isset($data[0]))
            $this->model->updateEntriesByCondition ($cond, array('value' => $value));
        else
        {
            $fields = array(
                'userid' => $this->user->getId(),
                'key'    => $key,
                'value'  => $value
            );
            $this->model->createEntry ($fields);
        }
    }
    
    public function unsetSetting($key)
    {
        $cond = new Moonlake_Model_Condition('AND');
        
        $cond->is('userid', $this->user->getId());
        $cond->is('key', $key);

        $this->model->deleteEntriesByCondition($cond);
    }
    
    public function existsSetting($key)
    {
        $cond = new Moonlake_Model_Condition('AND');
        
        $cond->is('userid', $this->user->getId());
        $cond->is('key', $key);

        $data = $this->model->getEntriesByCondition($cond);
        
        return isset($data[0]);
    }
    
    public function __get($name) {
        return $this->getSetting($name);
    }
    
    public function __set($name, $value) {
        $this->setSetting($name, $value);
    }
    
    public function __isset($name) {
        return $this->existsSetting($name);
    }
    
    public function __unset($name) {
        $this->unsetSetting($name);
    }
}

?>
