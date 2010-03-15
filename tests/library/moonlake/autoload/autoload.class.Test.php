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

require_once ('PHPUnit/Framework.php');

require_once ('library/moonlake/autoload/autoload.class.php');
Moonlake_Autoload_Autoload::initAutoload();

require_once ('PHPUnit/Framework/TestCase.php');

/**
 * Moonlake_Autoload_Autoload test case.
 */
class Moonlake_Autoload_Autoload_Test extends PHPUnit_Framework_TestCase {
    
    /**
     * @var Moonlake_Autoload_Autoload
     */
    private $Moonlake_Autoload_Autoload;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();
        
        // TODO Auto-generated Moonlake_Autoload_AutoloadTest::setUp()
        

        $this->Moonlake_Autoload_Autoload = new Moonlake_Autoload_Autoload(/* parameters */);
    
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        // TODO Auto-generated Moonlake_Autoload_AutoloadTest::tearDown()
        

        $this->Moonlake_Autoload_Autoload = null;
        
        parent::tearDown ();
    }
    
    /**
     * Tests Moonlake_Autoload_Autoload::registerLoader()
     */
    public function testRegisterLoader() {
        
        $loader1 = new Default_Loader();
        $loader2 = new Autoloader_Loader();
        
        Moonlake_Autoload_Autoload::registerLoader($loader1);
        $this->assertEquals(array('Default_Loader'), Moonlake_Autoload_Autoload::listLoaders());
        
        Moonlake_Autoload_Autoload::registerLoader($loader2);
        $this->assertEquals(array('Default_Loader', 'Autoloader_Loader'), Moonlake_Autoload_Autoload::listLoaders());
            
    }
    
}

