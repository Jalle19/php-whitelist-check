<?php

namespace Whitelist\Definition;

/**
 * Interface for definitions
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
interface IDefinition
{

	/**
	 * Validates the definition and returns false if the definition is
	 * invalid
	 * @return boolean
	 */
	public function validate();


	/**
	 * Returns true if the value matches the definition
	 *
	 * @param string $value
	 *
	 * @return boolean
	 */
	public function match($value);
}
