<?php

namespace Whitelist\Definition;

/**
 * Represents an IPv4 CIDR notation definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv4CIDR extends IPv4Definition
{

	public function validate()
	{
		$addressInfo = @$this->_addressHelper->parseAddress($this->_definition);

		if ($addressInfo instanceof \Net_IPv4)
			return $addressInfo->bitmask !== false;

		return false;
	}

	public function match($value)
	{
		return @$this->_addressHelper->ipInNetwork($value, $this->_definition);
	}

}
