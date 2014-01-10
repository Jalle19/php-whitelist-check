<?php

namespace Whitelist\Definition;

/**
 * Represents an IPv6 address definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv6Address extends IPv6Definition
{

	public function validate()
	{
		return $this->_addressHelper->checkIPv6($this->_definition);
	}

	public function match($value)
	{
		return $this->_definition === $value;
	}

}
