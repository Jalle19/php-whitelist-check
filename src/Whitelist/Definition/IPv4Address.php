<?php

namespace Whitelist\Definition;

/**
 * Represents an IPv4 address definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv4Address extends IPv4Definition
{

	public function validate()
	{
		return $this->_addressHelper->validateIP($this->_definition);
	}

	public function match($value)
	{
		return $this->_definition === $value;
	}

}
