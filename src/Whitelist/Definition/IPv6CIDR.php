<?php

namespace Whitelist\Definition;

/**
 * Represents an IPv6 CIDR definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class IPv6CIDR extends IPv6Definition
{

	public function validate()
	{
		// @ prevents E_STRICT errors about calling non-static methods statically
		return @is_array($this->_addressHelper->parseAddress($this->_definition));
	}

	public function match($value)
	{
		// We need to suppress errors cause Net_IPv6 contains some odd code
		return @$this->_addressHelper->checkIPv6($value) && 
			   @$this->_addressHelper->isInNetmask($value, $this->_definition);
	}

}
