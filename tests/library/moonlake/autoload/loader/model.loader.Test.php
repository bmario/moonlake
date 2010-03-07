<?php

require_once ('library/moonlake/autoload/autoload.class.php');
Moonlake_Autoload_Autoload::initAutoload();

require_once ('PHPUnit/Framework/TestCase.php');

/**
 * Model_Loader test case.
 */
class Model_Loader_Test extends PHPUnit_Framework_TestCase {

    /**
     * @var Model_Loader
     */
    private $Model_Loader;

    /**
     * Prepares the environment before running a test.
     */
    protected function setUp() {
        parent::setUp ();

        $this->Model_Loader = new Model_Loader(/* parameters */);

    }

    /**
     * Cleans up the environment after running a test.
     */
    protected function tearDown() {
        $this->Model_Loader = null;

        parent::tearDown ();
    }

    public function classnames() {
        return array(
            array('Moonlake_Model_Loader',''),
            array('Moonlake_Model','application/model/moonlake.model.php'),
            array('Anything_Model', 'application/model/anything.model.php'),
            array('Something_Anything_Loader', ''),
            array('Something_Anything', ''),
            array('Something', '')
        );
    }


    /**
     * @dataProvider classnames
     * Tests Model_Loader->classPath()
     */
    public function testClassPath($classname, $file) {

        $this->assertEquals($file, $this->Model_Loader->classPath($classname));

    }

}

