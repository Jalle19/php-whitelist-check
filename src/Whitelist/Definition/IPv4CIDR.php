<?php

namespace Whitelist\Definition;

/**
 * Represents an IPv4 CIDR notation definition
 *
 * @author Marc Seiler <mseiler@gmail.com>
 * @copyright Copyright &copy; Marc Seiler 2015-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv4CIDR extends Definition
{
    private $regexp = "/^[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\/([0-9]{1,2})?$/";

    public function validate()
    {
        return preg_match($this->regexp, $this->_definition) === 1;
    }

    public function match($value)
    {
        // Adapted from https://gist.github.com/tott/7684443
        
        list($range, $netmask) = explode('/', $this->_definition, 2);
        $rangeDecimal = ip2long($range);
        $ipDecimal = ip2long($value);
        $wildcardDecimal = pow(2, (32 - $netmask)) - 1;
        $netmaskDecimal = ~ $wildcardDecimal;
        return (($ipDecimal & $netmaskDecimal) == ($rangeDecimal & $netmaskDecimal));
    }
}
