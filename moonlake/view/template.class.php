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

namespace de\Moonlake\View;
use de\Moonlake\Autoload\Autoloader;
use de\Moonlake\Cache\Cache;

class Template {
    private $__name = "";
    private $__assigns = array();
    private $__xml = "";
    private $__render = "";

    public function  __construct($name) {
        $this->__name = $name;
        $path = Autoloader::getTemplatePath($name);

        if(!file_exists($path)) {
            die("Wanted template \"$name\" was not found.");
        }

        $this->__xml = file_get_contents($path);
    }

    public function assign($name, $value) {
        $this->__assigns[$name] = $value;
    }

    public function __get($name) {
        if(isset($this->__assigns[$name])) {
            return $this->__assigns[$name];
        }
        else return "";
    }

    public function render() {
        /*
         * using DOM to read the xml
         */
        $xml = new DOMDocument();
        $xml->loadXML($this->__xml);
        $this->__render = $xml->saveXML();
        /*
         *
         * replace macroaliases like <foreach>, <value> ...
         */
        foreach($xml->getElementsByTagName('value') as $node) {
            $this->__render = str_replace($xml->saveXML($node), '<macro name="value" varname="'.$node->getAttribute('name').'" cacheable="'.$node->getAttribute('cacheable').'"/>', $this->__render);
        }

        foreach($xml->getElementsByTagName('foreach') as $node) {
            $this->__render = str_replace($xml->saveXML($node), '<macro name="foreach" from="'.$node->getAttribute('from').'">', $this->__render);
        }
        $this->__render = str_replace('</foreach>', '</macro>', $this->__render);

        foreach($xml->getElementsByTagName('section') as $node) {
            $this->__render = str_replace('<section type="'.$node->getAttribute('type').'">', '<macro name="section" type="'.$node->getAttribute('type').'">', $this->__render);
        }
        $this->__render = str_replace('</section>', '</macro>', $this->__render);

        foreach($xml->getElementsByTagName('layer') as $node) {
            $this->__render = str_replace('<layer type="'.$node->getAttribute('type').'">', '<macro name="layer" type="'.$node->getAttribute('type').'">', $this->__render);
        }
        $this->__render = str_replace('</layer>', '</macro>', $this->__render);

        $this->__render = str_replace('<page>', '<macro name="page">', $this->__render);
        $this->__render = str_replace('</page>', '</macro>', $this->__render);

        /*
         * export xml, so we can use simple string replacements
         */
        $xml->loadXML($this->__render);
        $this->__render = $xml->saveXML();

        /*
         * expand <macro> tags
         *
         * this means call for every <macro name="$name"> the class $name_Macro
         */
        foreach($xml->getElementsByTagName('macro') as $node) {
            $name = $node->getAttribute('name').'_Macro';
            if(class_exists($name)) {
                // extract content
                $content = '';
                foreach($node->childNodes as $child) {
                    $content .= $xml->saveXML($child);
                }
                // extract attribute nodes.
                $attributes = array();
                foreach($node->attributes as $attr) {
                   $attributes[$attr->name] = $attr->value;
                }
                $macro = new $name($attributes, $content, $this->__assigns);
                $this->__render = str_replace($xml->saveXML($node), $macro->render(), $this->__render);
            }
            else continue;
        }

        $this->__render = substr($this->__render, 39);

        $cache = new Moonlake_Cache_Cache('view');
        $cache->save($this->__name, $this->__render);

        return $this->__render;
    }

    public function execute() {
        ob_start();
        $cache = new Cache('view');
        include($cache->getPath($this->__name));
        return ob_get_clean();
    }

}

?>
