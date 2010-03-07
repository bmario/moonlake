<?php

require_once ('library/moonlake/autoload/autoload.class.php');
Moonlake_Autoload_Autoload::initAutoload();

require_once ('PHPUnit/Framework/TestCase.php');

/**
 * Controller_Loader test case.
 */
class Controller_Loader_Test extends PHPUnit_Framework_TestCase {
    
    /**
     * @var Controller_Loader
     */
    private $Controller_Loader;
    
    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();
        
        $this->Controller_Loader = new Controller_Loader(/* parameters */);
    
    }
    
    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->Controller_Loader = null;
        
        parent::tearDown ();
    }
    
    public function classnames() {
        return array(
            array('Moonlake_Controller_Loader',''),
            array('Moonlake_Controller','application/controller/moonlake.controller.php'),
            array('Anything_Controller', 'application/controller/anything.controller.php'),
            array('Something_Anything_Loader', ''),
            array('Something_Anything', ''),
            array('Something', '')
        );
    }
    
    
    /**
     * @dataProvider classnames
     * Tests Controller_Loader->classPath()
     */
    public function testClassPath($classname, $file) {

        $this->assertEquals($file, $this->Controller_Loader->classPath($classname));
    
    }

}

