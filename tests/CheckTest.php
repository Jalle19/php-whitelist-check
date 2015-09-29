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
        $this->_checker = new \Whitelist\Check(true);
    }


    /**
     * Test that giving an invalid arguments to whitelist an exception is raised
     *
     * @param $arg
     * @dataProvider invalidArguments
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgument_whiteList($arg)
    {
        $this->_checker->whitelist(array($arg));
    }

    /**
     * Test that giving an invalid arguments to blacklist an exception is raised
     *
     * @param $arg
     * @dataProvider invalidArguments
     * @expectedException InvalidArgumentException
     */
    public function testInvalidArgument_blacklist($arg)
    {
        $this->_checker->blacklist(array($arg));
    }

    public function invalidArguments()
    {
        return array(
            array(new \stdClass()),
            array('ag?')
        );
    }


    /**
     * @param $expected
     * @param $value
     * @dataProvider matchDataProvider
     */
    public function testMatch_whitelist($expected, $value)
    {
        $this->_checker->whitelist(
            array(
                '10.2.3.1',
                '10.0.0.0/16',
                '2001:14d8:100:934b::3:1',
                '2001:14b8:100:934b::/64',
                'test.com',
                'example-domain.com',
                '*.another-example-domain.com',
                '*.example.com',
                new Whitelist\Definition\Domain('sub.example.com'),
            )
        );

        $this->check($expected, $value);
    }

    /**
     * @param $expected
     * @param $value
     * @dataProvider matchDataProvider
     */
    public function testMatch_blacklist($expected, $value)
    {
        $this->_checker->blacklist(
            array(
                '10.2.3.1',
                '10.0.0.0/16',
                '2001:14d8:100:934b::3:1',
                '2001:14b8:100:934b::/64',
                'test.com',
                'example-domain.com',
                '*.another-example-domain.com',
                '*.example.com',
                new Whitelist\Definition\Domain('sub.example.com'),
            )
        );

        $this->check(!$expected, $value);
    }

    private function check($expected, $value)
    {
        static::assertEquals($expected, $this->_checker->check($value));
    }

    public function matchDataProvider()
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
