<?php

namespace Whitelist\Definition;

use IpUtils\Expression\Subnet;
use IpUtils\Factory;

/**
 * Represents a CIDR notation 
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
abstract class IPCIDR extends Definition
{
    /**
     * Return true if the value is valid for this definition
     *
     * @param $value
     * @return boolean
     */
    public static function accept($value)
    {
        try
        {
            $subnet = static::getSubnet($value);

            return  ($subnet !== null);
        }
        catch (\Exception $e)
        {
            unset($e);
            return false;
        }
    }

	public function match($value)
	{
		try
		{
            $subnet = static::getSubnet($this->_definition);

			$address = Factory::getAddress($value);

			return $subnet->matches($address);
		}
		catch (\Exception $e)
		{
			unset($e);
			return false;
		}
	}

    /**
     * Return a subnet if the $value have one
     *
     * @param $value
     * @return null|Subnet
     */
    protected static function getSubnet($value) {
        $subnet = Factory::getExpression($value);

        if (!$subnet instanceof Subnet) {
            return null;
        }

        return $subnet;
    }

}
