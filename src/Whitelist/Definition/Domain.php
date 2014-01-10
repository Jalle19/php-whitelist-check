<?php

namespace Whitelist\Definition;

/**
 * Represents a domain definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class Domain extends Definition
{

	public function validate()
	{
		return true;
	}

	public function match($value)
	{
		return $this->_definition === $value;
	}

}
