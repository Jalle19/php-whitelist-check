<?php
/**
 * AbstractCheck.php
 *
 * @author cnastasi - Christian Nastasi <christian.nastasi@dxi.eu>
 * Created on Sep 29, 2015, 14:12
 * Copyright (C) DXI Ltd
 */

namespace Whitelist;

use InvalidArgumentException;
use Whitelist\Definition\IDefinition;

/**
 * Class AbstractCheck
 * @package Whitelist
 */
abstract class AbstractCheck implements ICheck
{
    /**
     * @var string[]
     */
    private $definitionClasses = array();

    /**
     * @var IDefinition[]
     */
    private $definitions = array();

    public function __construct() {
        $this->initDefinitions();
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public function check ($value) {
        $result = false;

        foreach ($this->definitions as $definition) {
            if ($definition->match($value)) {
                $result = true;
                break;
            }
        }

        return $result;
    }



    /**
     * @param string $definitionClass
     * @throws InvalidArgumentException
     */
    public function registerDefinitionClass ($definitionClass) {
        if ( !$this->isAValidDefinition($definitionClass)) {
            throw new InvalidArgumentException('Definition objects must implement IDefinition');
        }

        $this->definitionClasses[] = $definitionClass;
    }

    public function addDefinitions (array $definitions) {
        foreach ($definitions as $definition) {
            $definitionObject = $this->matchDefinition($definition);

            $this->definitions[] = $definitionObject;
        }
    }

    public function getDefinitionsCount () {
        return count($this->definitions);
    }

    private function initDefinitions()
    {
        $this->registerDefinitionClass('Whitelist\Definition\IPv4Address');
        $this->registerDefinitionClass('Whitelist\Definition\IPv4CIDR');
        $this->registerDefinitionClass('Whitelist\Definition\IPv6Address');
        $this->registerDefinitionClass('Whitelist\Definition\IPv6CIDR');
        $this->registerDefinitionClass('Whitelist\Definition\WildcardDomain');
        $this->registerDefinitionClass('Whitelist\Definition\Domain');
    }

    private function isAValidDefinition ($definitionClass) {
        return is_a($definitionClass, 'Whitelist\Definition\IDefinition', true);
    }

    /**
     * @param $definition
     * @return null
     * @throws InvalidArgumentException
     */
    private function matchDefinition($definition)
    {
        // echo "\nmatchDefinition: $definition\n";
        $definitionObject = $this->matchPreconfiguredObject($definition);
        // var_dump($definitionObject);

        if (!$definitionObject) {
            $definitionObject = $this->matchDefinitionClasses($definition);
        }
        //var_dump($definitionObject)//..;

        if (!$definitionObject) {
            throw new InvalidArgumentException('Unable to parse definition "' . $definition . '"');
        }

        return $definitionObject;
    }

    /**
     * @param $definition
     * @return IDefinition|null
     * @throws InvalidArgumentException
     */
    private function matchPreconfiguredObject($definition)
    {
        if (is_object($definition)) {
            if (!($definition instanceof IDefinition)) {
                throw new InvalidArgumentException('Definition objects must implement IDefinition');
            }

            return $definition;
        }

        return null;
    }

    /**
     * @param string $definition
     * @return IDefinition|null
     */
    private function matchDefinitionClasses($definition)
    {
        $definitionObject = null;

        foreach ($this->definitionClasses as $definitionClass) {
            if ($this->definitionIsAccepted($definitionClass, $definition)) {
                $definitionObject = new $definitionClass($definition);
                break;
            }
        }

        return $definitionObject;
    }

    private function definitionIsAccepted ($definitionClass, $definition) {

        return call_user_func(array($definitionClass, 'accept'), $definition);
    }
}
