<?php

require_once ('library/moonlake/autoload/autoload.class.php');
require_once ('library/moonlake/autoload/loader/default.loader.php');
require_once ('library/moonlake/autoload/loader/autoloader.loader.php');

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

