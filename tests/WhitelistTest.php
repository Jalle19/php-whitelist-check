<?php
/**
 * WhitelistCheckTest.php
 *
 * @author cnastasi - Christian Nastasi <christian.nastasi@dxi.eu>
 * Created on Sep 29, 2015, 13:53
 * Copyright (C) DXI Ltd
 */
use Whitelist\Check;
use Whitelist\WhitelistCheck;

/**
 * Class WhitelistCheckTest
 */
class WhitelistTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var WhitelistCheck
     */
    private $check;

    public function setUp()
    {
        $this->check = new WhitelistCheck();
    }

    /**
     * @test
     * @expectedException InvalidArgumentException
     * @dataProvider invalidArguments
     */
    public function testInvalidArgument($arg)
    {
        $this->check->addDefinitions(array($arg));
    }

    public function invalidArguments () {
        return array(
            array(new \stdClass()),
            array('ag?')
        );
    }
}
