<?php

namespace Whitelist\Definition;

use IpUtils\Factory;

/**
 * Represents an IP address definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
abstract class IPAddress extends Definition
{

	public function match($value)
	{
		try
		{
			$address = Factory::getAddress($this->_definition);
			$otherAddress = Factory::getExpression($value);
			return $address->matches($otherAddress);
		}
		catch (\Exception $e)
		{
			unset($e);
			return false;
		}
	}

}
