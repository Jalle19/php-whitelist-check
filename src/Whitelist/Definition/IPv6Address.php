<?php

namespace Whitelist\Definition;

use IpUtils\Address\IPv6;

/**
 * Represents an IPv6 address definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv6Address extends IPAddress
{
    /**
     * Return true if the value is valid for this definition
     *
     * @param $value
     * @return boolean
     */
    public static function accept($value)
    {
        return IPv6::isValid($value);
    }
}
