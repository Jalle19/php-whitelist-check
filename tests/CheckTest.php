com<?php

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
     * Test invalid objects passed to blacklist()
     * @expectedException InvalidArgumentException
     */
    public function testInvalidDefinitionObjectOnBlacklist()
    {
        $this->_checker->blacklist(array(
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
     * Test unparsable definition passed to blacklist()
     * @expectedException InvalidArgumentException
     */
    public function testUnknownDefinitionOnBlacklist()
    {
        $this->_checker->blacklist(array(
           'ag?', // definition class should not be able to be determined
       ));
    }

	/**
     * This test also tests that the whitelist definitions are valid, ie. they
     * don't throw an exception
     * @dataProvider whitelistMatchDataProvider
     */
    public function testWhitelistMatch($expected, $expression)
    {
        $this->_checker->whitelist(array(
           '10.2.3.1',
           '10.0.0.0/16',
           '2001:14d8:100:934b::3:1',
           '2001:14b8:100:934b::/64',
           'test.com',
           'example-domain.com',
           '*.another-example-domain.com',
           '*.example.com',
           new Whitelist\Definition\Domain('sub.example.com'),
       ));

        $this->assertEquals($expected, $this->_checker->check($expression));
    }

    /**
     * This test also tests that the blacklist definitions are valid, ie. they
     * don't throw an exception
     * @dataProvider blacklistMatchDataProvider
     */
    public function testBlacklistMatch($expected, $expression)
    {
        $this->_checker->blacklist(array(
           '10.2.3.1',
           '10.0.0.0/16',
           '2001:14d8:100:934b::3:1',
           '2001:14b8:100:934b::/64',
           'test.com',
           'example-domain.com',
           '*.another-example-domain.com',
           '*.example.com',
           new Whitelist\Definition\Domain('sub.example.com'),
       ));

        $this->assertEquals($expected, $this->_checker->check($expression));
    }

    /**
     * This test also tests that the both definitions are valid, ie. they
     * don't throw an exception
     * @dataProvider bothMatchDataProvider
     */
    public function testBothMatch($expected, $expression)
    {
        $this->_checker->whitelist(array(
           '10.2.3.1',
           '2001:14b8:100:934b::/64',
           'test.com',
           '*.another-example-domain.com',
           new Whitelist\Definition\Domain('sub.example.com'),
        ));

        $this->_checker->blacklist(array(
           '10.0.0.0/16',
           '2001:14b8:100:934b::/64',
           'example-domain.com',
           '*.example.com'
       ));

        $this->assertEquals($expected, $this->_checker->check($expression));
    }

	public function whitelistMatchDataProvider()
	{
		return array(
			array(true,   '10.2.3.1'),
			array(false,  '10.2.3.2'),
			array(true,   '10.0.1.1'),
			array(false,  '10.1.1.1'),
			array(true,   '2001:14d8:100:934b::3:1'),
			array(false,  '2001:14d8:100:934b::3:2'),
			array(true,   '2001:14b8:100:934b::12b1:1'),
			array(false,  '2001:14c8:100:934b::12b1:1'),
			array(true,   'test.com'),
			array(true,   'anything.goes.example.com'),
			array(true,   'sub.example.com'),
			array(false,  'test.example2.com'),
			array(true,   'example-domain.com'),
			array(true,   'test.another-example-domain.com')
		);
	}

    public function blacklistMatchDataProvider()
    {
        return array(
            array(true,   '10.2.3.1'),
            array(false,  '10.2.3.2'),
            array(true,   '10.0.1.1'),
            array(false,  '10.1.1.1'),
            array(true,   '2001:14d8:100:934b::3:1'),
            array(false,  '2001:14d8:100:934b::3:2'),
            array(true,   '2001:14b8:100:934b::12b1:1'),
            array(false,  '2001:14c8:100:934b::12b1:1'),
            array(true,   'test.com'),
            array(true,   'anything.goes.example.com'),
            array(true,   'sub.example.com'),
            array(false,  'test.example2.com'),
            array(true,   'example-domain.com'),
            array(true,   'test.another-example-domain.com')
        );
    }

    public function bothMatchDataProvider()
    {
        return array(
            array(true,   '10.2.3.1'),
            array(false,  '10.2.3.2'),
            array(true,   '10.0.1.1'),
            array(false,  '10.1.1.1'),
            array(true,   '2001:14d8:100:934b::3:1'),
            array(false,  '2001:14d8:100:934b::3:2'),
            array(true,   '2001:14b8:100:934b::12b1:1'),
            array(false,  '2001:14c8:100:934b::12b1:1'),
            array(true,   'test.com'),
            array(true,   'anything.goes.example.com'),
            array(true,   'sub.example.com'),
            array(false,  'test.example2.com'),
            array(true,   'example-domain.com'),
            array(true,   'test.another-example-domain.com')
        );
    }

}
