<?php

namespace Safelist;

use Safelist\Definition\IDefinition;

/**
 * Main class for checking values against a safelist. It provides a method to 
 * set up the safelist and a method to match arbitrary string against the 
 * safelist.
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class Check
{

	/**
	 * @var IDefinition[] the safelist definitions
	 */
	private $_definitions = array();

	/**
	 * Parses the safelist definitions into respective objects
	 * @param array $safelist list of definition strings
	 * @throws \InvalidArgumentException if the definition type couldn't be
	 * determined
	 */
	public function safelist(array $safelist)
	{
		$this->_definitions = array();
		
		foreach ($safelist as $definition)
		{
			// Pre-configured object
			if (is_object($definition))
			{
				if ($definition instanceof Definition\IDefinition)
					$definitionObject = $definition;
				else
					throw new \InvalidArgumentException('Definition objects must implement IDefinition');
			}
			// IPv4 address
			elseif (preg_match('/[a-z:\/]/', $definition) === 0)
				$definitionObject = new Definition\IPv4Address($definition);
			// IPv4 CIDR notation
			elseif (preg_match('/[a-z:]/', $definition) === 0)
				$definitionObject = new Definition\IPv4CIDR($definition);
			// IPv6 address
			elseif (preg_match('/^[0-9a-f:]+$/', $definition))
				$definitionObject = new Definition\IPv6Address($definition);
			// IPv6 CIDR notation
			elseif (preg_match('/^[0-9a-f:\/]+$/', $definition))
				$definitionObject = new Definition\IPv6CIDR($definition);
			// Wildcard domain
			elseif (preg_match('/^\*\.[\w\.\-]+$/', $definition))
				$definitionObject = new Definition\WildcardDomain($definition);
			// Domain
			elseif (preg_match('/^[\w\.\-]+$/', $definition))
				$definitionObject = new Definition\Domain($definition);
			else
				throw new \InvalidArgumentException('Unable to parse definition "'.$definition.'"');

			$this->_definitions[] = $definitionObject;
		}
	}
	
	/**
	 * Checks the specified value against all configured definitions and 
	 * returns true if at least one definition considers it a match
	 * @param string $value the value to be checked
	 * @return boolean
	 */
	public function check($value)
	{
		foreach ($this->_definitions as $definition)
			if ($definition->match($value))
				return true;

		return false;
	}

}
