<?php

namespace Whitelist;

use InvalidArgumentException;
use Whitelist\Definition\IDefinition;

/**
 * Main class for checking values against a whitelist. It provides a method to
 * set up the whitelist and a method to match arbitrary string against the
 * whitelist.
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
class Check_old
{

    /**
     * @var IDefinition[] the whitelist definitions
     */
    private $_whitelistDefinitions = array();

    /**
     * @var IDefinition[] the blacklist definitions
     */
    private $_blacklistDefinitions = array();

    /**
     * @var string[] the registered definition classes
     */
    private $_definitionClasses = array();

    /**
     * @var callable
     */
    private $_validationLogic;

    /**
     * @param bool $permissiveMode If true, default whitelist is everything, otherwise is nothing
     */
    public function __construct($permissiveMode = false)
    {
        $this->initDefinitions();

        $this->permissiveMode = (bool) $permissiveMode;
    }

    /**
     * Parses the whitelist definitions into respective objects
     * @param array $whitelist list of definition strings
     * @throws InvalidArgumentException if the definition type couldn't be
     * determined
     */
    public function whitelist(array $whitelist)
    {
        $this->_whitelistDefinitions = array();

        $this->matchDefinitions($this->_whitelistDefinitions, $whitelist);
    }

    /**
     * Parses the blacklist definitions into respective objects
     * @param array $blacklist list of definition strings
     * @throws InvalidArgumentException if the definition type couldn't be
     * determined
     */
    public function blacklist(array $blacklist)
    {
        $this->_blacklisttDefinitions = array();

        $this->match($this->_blacklistDefinitions, $blacklist);
    }

    /**
     * Checks the specified value against all configured definitions and
     * returns true if: the value is in the  white list but not in the blacklist at least one definition considers it a match
     * @param string $value the value to be checked
     * @return boolean
     */
    public function check($value)
    {
       return $this->isInWhitelist($value) && !$this->isInBlacklist($value);
    }

    /**
     * @param $value
     * @return bool
     */
    public function isInWhitelist($value) {
        return count($this->_whitelistDefinitions) !== 0
               ? $this->checkDefinitions($this->_blacklistDefinitions, $value)
               : $this->permissiveMode;
    }

    /**
     * @param $value
     * @return bool
     */
    public function isInBlacklist($value) {
        return count($this->_blacklistDefinitions) !== 0
               ? $this->checkDefinitions($this->_blacklistDefinitions, $value)
               : false;
    }

    /**
     * @param $definitionClass
     */
    public function registerDefinition($definitionClass)
    {
        if (!is_a($definitionClass, 'Whitelist\Definition\IDefinition', true)) {
            throw new InvalidArgumentException('Definition objects must implement IDefinition');
        }

        $this->_definitionClasses[] = $definitionClass;
    }

    /**
     * @param callable $validationLogic
     */
    public function setValidationLogic(callable $validationLogic) {
        $this->_validationLogic = $validationLogic;
    }



    private function initDefinitions()
    {
        $this->registerDefinition('Whitelist\Definition\IPv4Address');
        $this->registerDefinition('Whitelist\Definition\IPv4CIDR');
        $this->registerDefinition('Whitelist\Definition\IPv6Address');
        $this->registerDefinition('Whitelist\Definition\IPv6CIDR');
        $this->registerDefinition('Whitelist\Definition\WildcardDomain');
        $this->registerDefinition('Whitelist\Definition\Domain');

//        $this->registerDefinition('/^((([1-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])[.]){3}([1-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/',        'Whitelist\Definition\IPv4Address');
//        $this->registerDefinition('/^((([1-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])[.]){3}([1-9]|[1-9][0-9]|[1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])[\/]([1-9]|[1-2][0-9]|[3][0-2]))$/',          'Whitelist\Definition\IPv4CIDR');
//        //$this->registerDefinition('/^[0-9a-f:]+$/',    'Whitelist\Definition\IPv6Address');
//
//        $this->registerDefinition(
//            '/^(([0-9a-fA-F]{1,4}:){7,7}[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,7}:|([0-9a-fA-F]{1,4}:){1,6}:[0-9a-fA-F]{1,4}|([0-9a-fA-F]{1,4}:){1,5}(:[0-9a-fA-F]{1,4}){1,2}|([0-9a-fA-F]{1,4}:){1,4}(:[0-9a-fA-F]{1,4}){1,3}|([0-9a-fA-F]{1,4}:){1,3}(:[0-9a-fA-F]{1,4}){1,4}|([0-9a-fA-F]{1,4}:){1,2}(:[0-9a-fA-F]{1,4}){1,5}|[0-9a-fA-F]{1,4}:((:[0-9a-fA-F]{1,4}){1,6})|:((:[0-9a-fA-F]{1,4}){1,7}|:)|fe80:(:[0-9a-fA-F]{0,4}){0,4}%[0-9a-zA-Z]{1,}|::(ffff(:0{1,4}){0,1}:){0,1}((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])|([0-9a-fA-F]{1,4}:){1,4}:((25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9])\.){3,3}(25[0-5]|(2[0-4]|1{0,1}[0-9]){0,1}[0-9]))$/',
//            'Whitelist\Definition\IPv6Address'
//        );
//
//        $this->registerDefinition('/^[0-9a-f:\/]+$/',  'Whitelist\Definition\IPv6CIDR');
//        $this->registerDefinition('/^\*\.[\w\.\-]+$/', 'Whitelist\Definition\WildcardDomain');
//        $this->registerDefinition('/^[\w\.\-]+$/',     'Whitelist\Definition\Domain');
    }

    /**
     * @param IDefinition[] $definitions
     * @param mixed $value
     * @return bool
     */
    private function checkDefinitions (array $definitions, $value) {
        foreach ($definitions as $definition) {
            if ($definition->match($value)) {
                return true;
            }
        }

        return false;
    }

    public function debug() {
        $output = array ();
        $output['whitelist'] = array();
        $output['blacklist'] = array();

        foreach ($this->_whitelistDefinitions as $definition) {
            $output['whitelist'][] = get_class($definition);
        }

        foreach ($this->_blacklistDefinitions as $definition) {
            $output['blacklist'][] = get_class($definition);
        }

        return $output;
    }
}
