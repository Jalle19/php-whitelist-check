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
		// @ prevents E_STRICT errors about calling non-static methods statically
		return @$this->_addressHelper->parseAddress($this->_definition) !== false;
	}

	public function match($value)
	{
		return $this->_addressHelper->ipInNetwork($value, $this->_definition);
	}

}
