<?php

namespace de\Moonlake\Config;

class Config {

    private $file;
    private $cfg;
    private $changed;

    public function __construct($name) {
        $this->file = "config/{$name}.config.php";
        $this->changed = false;

        if(file_exists($this->file)) {

            include($this->file);

            if(isset($_CONFIG)) {
                $this->cfg = $_CONFIG;
                return;
            }
        }

        $this->cfg = array();
    }

    public function __get($name) {
        if(isset($this->cfg[$name])) {
            return $this->cfg[$name];
        }
        return '';
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
            		if($value == array()) {
            			$php = 'array()';
            		}
            		else {
	            		$php = 'array (';
	            		foreach($value as $val) {
	            			$php .= "$val, ";
	            		}
	            		$php = substr($php, 0, -2);
	            		$php .= ')';
            		}

            		$file .= '$_CONFIG[\''.$name.'\'] = '.$php.";\r\n\r\n";
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

}

?>
