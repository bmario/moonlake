<?php

/*
 * (c) 2009 by Mario Bielert <mario@moonlake.de>
 * Moonlake - Framework
 */

/*
 * This work is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or any later version.
 *
 * This work is distributed in the hope that it will be useful,
 * but without any warranty; without even the implied warranty of merchantability
 * or fitness for a particular purpose.
 * See version 2 and version 3 of the GNU General Public License for more details.
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

namespace de\Moonlake\Cache;

/**
 * This class is an abstract surface to the cache
 */
class Cache {
    private $name;
    /**
     * constructor.
     * Give it a name or hint, what you about to cache
     *
     * @param name
     */
     public function  __construct($name) {
         $this->name = $name;
         if(!file_exists("cache/$name")) mkdir("cache/$name");
     }

     public function save($id, $value) {
         file_put_contents("cache/{$this->name}/$id.cache.php", $value);
     }

     public function load($id) {
         if($this->valid($id)) {
            return file_get_contents("cache/{$this->name}/$id.cache.php");
         }
         else return false;
     }

     public function valid($id) {
         return file_exists("cache/{$this->name}/$id.cache.php");
     }

     public function getPath($id) {
         return "cache/{$this->name}/$id.cache.php";
     }

     public function remove($id) {
         if($this->valid($id)) unlink("cache/{$this->name}/$id.cache.php");
     }
}

?>