<?php


require_once ('library/moonlake/autoload/autoloader.class.php');
require_once ('library/moonlake/autoload/loader/default.loader.php');

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

