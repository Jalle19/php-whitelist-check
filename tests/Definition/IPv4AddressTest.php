<?php

/**
 * Tests for IPv4Address
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv4AddressTest extends DefinitionTest
{

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEmptyDefinition()
	{
		$this->_definition = new \Whitelist\Definition\IPv4Address('');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValidate()
	{
		$this->_definition = new \Whitelist\Definition\IPv4Address('not.an.ipv4.address');
	}

	public function testMatch()
	{
		$this->_definition = new \Whitelist\Definition\IPv4Address('192.168.1.1');
		$this->assertEquals(true, $this->_definition->match('192.168.1.1'));
		$this->assertEquals(false, $this->_definition->match('192.168.1.2'));
	}

}
