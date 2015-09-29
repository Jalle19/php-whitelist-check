<?php

namespace Whitelist\Definition;

/**
 * Represents a wildcard domain definition
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class WildcardDomain extends Definition
{

	public function match($value)
	{
		// Remove the wildcard part and check if it matches the end of $value
		$domain = substr($this->_definition, 1);

		return substr($value, -strlen($domain)) === $domain;
	}

    /**
     * Return true if the value is valid for this definition
     *
     * @param $value
     * @return boolean
     */
    public static function accept($value)
    {
        return preg_match('/^\*\.[\w\.\-]+$/', $value) === 1;
    }
}
