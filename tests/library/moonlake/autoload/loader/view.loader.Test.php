<?php

require_once ('library/moonlake/autoload/autoloader.class.php');
require_once ('library/moonlake/autoload/loader/controller.loader.php');

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

		$this->View_Loader = new View_Loader(/* parameters */);

	}

	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->View_Loader = null;

		parent::tearDown ();
	}

	public function classnames() {
		return array(
			array('Moonlake_View_Loader',''),
			array('Moonlake_View','application/View/moonlake.view.php'),
			array('Anything_View', 'application/View/anything.view.php'),
			array('Something_Anything_Loader', ''),
			array('Something_Anything', ''),
			array('Something', '')
		);
	}


	/**
	 * @dataProvider classnames
	 * Tests View_Loader->classPath()
	 */
	public function testClassPath($classname, $file) {

		$this->assertEquals($file, $this->View_Loader->classPath($classname));

	}

}

