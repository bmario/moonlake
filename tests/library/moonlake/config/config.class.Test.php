<?php

require_once('library/moonlake/config/config.class.php');

require_once('PHPUnit/Framework/TestCase.php');

/**
 * Config test case.
 */
class Moonlake_Config_Config_Test extends PHPUnit_Framework_TestCase {
	
	/**
	 * @var Config
	 */
	private $Config;
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();		

		$this->Config = new Moonlake_Config_Config("test");
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {

		@$this->Config = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Getprovider
	 */
	public function getProvider() {
		return array(
			array('test1', 'test1'),
			array('test2' , 'test2'),
			array('test3' , 'test3'),
			array('test4' , 'test4'),
			array('test5', array(
				'test5.0',
				'test5.1',
				'test5.2',
				'test5.3'))
		);
	} 
	
	/**
	 * @dataProvider getProvider
	 * Tests Config->__get()
	 */
	public function test__get($key, $val) {
		$this->assertEquals($val, $this->Config->{$key});
	}
	
	/**
	 * Tests Config->__set()
	 */
	public function test__set() {
		
		$this->Config->test10 = 'test10';
		
		$this->assertEquals('test10', $this->Config->test10);
		
		$this->Config->test10 = array('test101','test102');

		$this->assertEquals(array('test101','test102'), $this->Config->test10);
		
	}
	
	/**
	 * Tests Config->__unset()
	 */
	public function test__unset() {
		
		$this->Config->test10 = 'somedata';
		
		unset($this->Config->test10);
		
		$this->assertEquals(null, $this->Config->test10);
	
	}
	
	/**
	 * Tests Config->__isset()
	 */
	public function test__isset() {
		
		$this->assertEquals(true, isset($this->Config->test1));
		$this->assertEquals(false, isset($this->Config->test11111));
	
	}
	
}

