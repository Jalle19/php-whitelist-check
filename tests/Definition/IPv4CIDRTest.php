<?php

/**
 * Test for IPv4CIDR
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv4CIDRTest extends DefinitionTest
{

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEmptyDefinition()
	{
		$this->_definition = new \Whitelist\Definition\IPv4CIDR('');
	}

	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValidate()
	{
		$this->_definition = new \Whitelist\Definition\IPv4CIDR('10.10.0.3');
	}

	public function testMatch()
	{
		$this->_definition = new \Whitelist\Definition\IPv4CIDR('10.10.0.0/16');
		$this->assertEquals(true, $this->_definition->match('10.10.1.1'));
		$this->assertEquals(true, $this->_definition->match('10.10.76.1'));
		$this->assertEquals(false, $this->_definition->match('110.1.76.1'));
	}

}
