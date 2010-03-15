<?php

/*
 *  Copyright 2010 Mario Bielert <mario@moonlake.de>
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

require_once ('library/moonlake/autoload/autoload.class.php');
Moonlake_Autoload_Autoload::initAutoload();

require_once ('PHPUnit/Framework/TestCase.php');

/**
 * Default_Loader test case.
 */
class Default_Loader_Test extends PHPUnit_Framework_TestCase {
    
    /**
     * @var Default_Loader
     */
    private $Default_Loader;
        
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();
        
        $this->Default_Loader = new Default_Loader(/* parameters */);
    
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {

        $this->Default_Loader = null;
        
        parent::tearDown ();
    }
    
    public function classnames() {
        return array(
            array('Moonlake_Anything_Loader','library/moonlake/anything/loader.class.php'),
            array('Anything_Loader', ''),
            array('Something_Anything_Loader', ''),
            array('Moonlake_Anything',''),
            array('Moonlake','')
        );
    }
    
    /**
     * @dataProvider classnames
     */
    public function testClassPath($name, $path) {

        $this->assertEquals($path, $this->Default_Loader->classPath($name));
    
    }

}

