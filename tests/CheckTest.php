<?php

/**
 * Tests for the Check class
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class CheckTest extends PHPUnit_Framework_TestCase
{

	/**
	 * @var Whitelist\Check the check instance
	 */
	protected $_checker;

	/**
	 * Initialize the checker
	 */
	protected function setUp()
	{
		$this->_checker = new \Whitelist\Check();
	}

	/**
	 * Test invalid objects passed to whitelist()
	 * @expectedException InvalidArgumentException
	 */
	public function testInvalidDefinitionObject()
	{
		$this->_checker->whitelist(array(
			new stdClass(),
		));
	}

	/**
	 * Test unparsable definition passed to whitelist()
	 * @expectedException InvalidArgumentException
	 */
	public function testUnknownDefinition()
	{
		$this->_checker->whitelist(array(
			'ag?', // definition class should not be able to be determined
		));
	}

	/**
	 * Test that match() works
	 */
	public function testMatch()
	{
		$this->_checker->whitelist(array(
			'10.0.3.1',
			'10.0.0.0/16',
			'2001:14b8:100:934b::3:1',
			'2001:14b8:100:934b::/64',
			'*.example.com',
			new Whitelist\Definition\Domain('sub.example.com'),
		));

		$this->assertEquals(true, $this->_checker->check('10.0.3.1'));
		$this->assertEquals(true, $this->_checker->check('10.0.1.1'));
		$this->assertEquals(true, $this->_checker->check('2001:14b8:100:934b::3:1'));
		$this->assertEquals(true, $this->_checker->check('2001:14b8:100:934b::12b1:1'));
		$this->assertEquals(true, $this->_checker->check('anything.goes.example.com'));
		$this->assertEquals(true, $this->_checker->check('sub.example.com'));
	}

}
