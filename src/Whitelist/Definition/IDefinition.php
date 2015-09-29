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
	 * Returns true if the value matches the definition
	 */
	public function match($value);

    /**
     * Return true if the value is valid for this definition
     *
     * @param $value
     * @return boolean
     */
    public static function accept($value);
}
