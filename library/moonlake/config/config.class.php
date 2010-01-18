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

class Moonlake_Config_Config {

    private $file;
    private $cfg;
    private $changed;

    public function __construct($name) {
        $this->file = "config/{$name}.config.php";
        $this->changed = false;

        try {

        	include($this->file);
        	
            if(isset($_CONFIG)) $this->cfg = $_CONFIG;
            else $this->cfg = array();
            
        }
		catch (Exception $e) {
			$this->cfg = array();
		}
    }

    public function __get($name) {
    	if(isset($this->cfg[$name])) {
            return $this->cfg[$name];
        }
        return null;
    }

    public function __set($name, $value)
    {
        if(!isset($this->cfg[$name]) or $this->cfg[$name] <> $value) {
            $this->cfg[$name] = $value;
            $this->changed = true;
        }
    }

    public function __unset($name) {
        if(isset($this->cfg[$name])) {
            unset($this->cfg[$name]);
            $this->changed = true;
        }
    }

    public function __isset($name) {
        return isset($this->cfg[$name]);
    }

    public function  __destruct() {
        if($this->changed) {
            $file = '<?php '."\r\n\r\n";
            foreach($this->cfg as $name => $value)
            {
            	if(is_array($value)) {
            		foreach($value as $val) {
            			$file .= '$_CONFIG[\''.$name.'\'][] = \''.$val."';\r\n";
            		}
            		$file .= "\r\n";
            	}
            	else {
            		$file .= '$_CONFIG[\''.$name.'\'] = \''.$value."';\r\n\r\n";
            	}
            }
            $file .= '?>';

            file_put_contents($this->file, $file);

            $this->changed = false;

        }
    }
    
    /**
     * Returns an array with all keys=>values, but it does NOT track any changes on it
     */
    public function returnAll() {
    	return $this->cfg;
    }

}

?>
