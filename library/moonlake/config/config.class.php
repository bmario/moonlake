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
 * This class provides an easy interface for storing and reading configuration
 * information.
 *
 * Every access to the options is done with the magic functions __get(), __set()
 * __isset(), __unset()
 */
class Moonlake_Config_Config {

    // this contains the filename
    private $__file__;

    // this array contains all settings
    private $__cfg__;

    // this is a flag, if some information was changed, so we need to save it.
    private $__changed__;

    /**
     * The constructor needs a name for the config.
     * The name defines, where config searches for the configuration.
     *
     * This class looks for cinfugrations in the file:
     * config/{$name}.config.php
     *
     * @param String $name the name of the config
     */
    public function __construct($name) {
        $this->__file__ = "config/{$name}.config.php";
        $this->__changed__ = false;

        try {

            @include($this->__file__);
            
            if(isset($_CONFIG)) $this->__cfg__ = $_CONFIG;
            else $this->__cfg__ = array();
            
        }
        catch (Exception $e) {
            $this->__cfg__ = array();
        }
    }


    /**
     * The __get() magic. This allows sth. like this:
     *
     * $option = $config->optionname;
     */
    public function __get($name) {
        if(isset($this->__cfg__[$name])) {
            return $this->__cfg__[$name];
        }
        return null;
    }

    /**
     * The __set() maigc. This allows sth. like this:
     *
     * $config->optionname = newvalue;
     *
     * Note that if the entry allready exists, it will be overriden and that
     * if the entry does not exists, it will be created.
     */
    public function __set($name, $value)
    {
        if(!isset($this->__cfg__[$name]) or $this->__cfg__[$name] <> $value) {
            $this->__cfg__[$name] = $value;
            $this->__changed__ = true;
        }
    }

    /**
     * The __unset() magic. This allows sth. like this:
     *
     * unset($config->optionname);
     */
    public function __unset($name) {
        if(isset($this->__cfg__[$name])) {
            unset($this->__cfg__[$name]);
            $this->__changed__ = true;
        }
    }

    /**
     * The __isset() magic. This allows sth. like this:
     *
     * isset($config->optionname);
     */
    public function __isset($name) {
        return isset($this->__cfg__[$name]);
    }

    /**
     * The destructor automatically saves all changes to the file, if there are
     * some.
     *
     * FIXME really use windows-style newlines?
     */
    public function  __destruct() {
        // are there any changes?
        if($this->__changed__) {
            // yes, so began file output

            // first php-tags
            $file = '<?php '."\r\n\r\n";

            // for every config we hase create an entry
            foreach($this->__cfg__ as $name => $value)
            {
                // if it's an array, create multiple entries
                if(is_array($value)) {
                    foreach($value as $val) {
                        $file .= '$_CONFIG[\''.$name.'\'][] = \''.$val."';\r\n";
                    }
                    $file .= "\r\n";
                }
                // else create on entry
                else {
                    $file .= '$_CONFIG[\''.$name.'\'] = \''.$value."';\r\n\r\n";
                }
            }

            // close php tags
            $file .= '?>';

            // save all to the correct file
            file_put_contents($this->__file__, $file);
        }
    }
    
    /**
     * Returns an array with all keys=>values, but it does NOT track any changes
     * on it, so don't exspact any changes to be saved!
     *
     * @return array all config options
     */
    public function returnAll() {
        return $this->__cfg__;
    }


    /**
     * This method returns the path to the cnofig file, which is used.
     *
     * @return String path to config file
     */
    public function getFilePath() {
        return $this->__file__;
    }
}

?>