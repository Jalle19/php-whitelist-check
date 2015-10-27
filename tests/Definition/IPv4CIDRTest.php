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
     * Test various combinations of CIDR's (valid and invalid)
     *
     * @return null
     */
    public function testValidate()
    {
        $pass = false;

        // Sorry have to do this instead of using @dataProvider to avoid breaking the contract.
        foreach ($this->cidrProvider() as $cidr) {
            list ($expected, $address) = $cidr;
            try {
                $this->_definition = new \Whitelist\Definition\IPv4CIDR($address);
                $pass = true;
            } catch (Exception $e) {
                $pass = false;
            }
            $this->assertEquals($expected, $pass);
        }

    }

    public function cidrProvider()
    {
        return array(
            array(false, '10.10.0.3'),
            array(false, '10.10.0.0/23445'),
            array(true, '10.10.0.0/16'),
            array(true, '0.0.0.0/0'),
        );
    }

    /**
     * @dataProvider provider
     */
    public function testMatch($expected, $address)
    {
        // testing if address matches CIDR
        $this->_definition = new \Whitelist\Definition\IPv4CIDR('10.10.0.0/16');
        $this->assertEquals($expected, $this->_definition->match($address));

        // testing that all of them pass zero CIDR
        $this->_definition = new \Whitelist\Definition\IPv4CIDR('0.0.0.0/0');
        $this->assertEquals(true, $this->_definition->match($address));
    }

    public function provider()
    {
        return array(
            array(true, '10.10.1.1'),
            array(true, '10.10.76.1'),
            array(false, '110.1.76.1'),
        );
    }
}
