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
	public function match($value)
	{
		return $this->_definition === $value;
	}

    /**
     * Return true if the value is valid for this definition
     *
     * @param $value
     * @return boolean
     */
    public static function accept($value)
    {
        // The domain name cannot be empty
        if ($value === '') {
            return false;
        }

        // None of the parts in the domain name can contain invalid characters
        // or begin/end with a dash
        foreach (explode('.', $value) as $part)
        {
            if (!preg_match('/^[a-zA-Z0-9-\.]+$/', $part) ||
                substr($part, 0, 1) === '-' ||
                substr($part, -1) === '-')
            {
                return false;
            }
        }

        return true;
    }
}
