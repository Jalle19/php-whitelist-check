<?php

/**
 * Test for IPv4CIDR
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2016-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv6CIDRTest extends DefinitionTest
{


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testEmptyDefinition()
	{
		new \Whitelist\Definition\IPv6CIDR('');
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testValidate()
	{
		$cidr = new \Whitelist\Definition\IPv6CIDR('2001::/129');

		$this->assertFalse($cidr->validate());
	}


	/**
	 * 
	 */
	public function testValidateTrue() {
		$cidr = new \Whitelist\Definition\IPv6CIDR('2001::/3');

		$this->assertTrue($cidr->validate());
	}

}
