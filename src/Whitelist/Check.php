<?php
/**
 * Check.php
 *
 * @author cnastasi - Christian Nastasi <christian.nastasi@dxi.eu>
 * Created on Sep 29, 2015, 15:10
 * Copyright (C) DXI Ltd
 */

namespace Whitelist;

/**
 * Class Check
 * @package Whitelist
 */
class Check implements ICheck
{
    /**
     * @var bool
     */
    private $permissiveMode;

    /**
     * @var WhitelistCheck
     */
    private $whitelistCheck;

    /**
     * @var BlacklistCheck
     */
    private $blacklistCheck;

    /**
     * @param bool $permissiveMode
     */
    public function __construct($permissiveMode = false)
    {

        $this->permissiveMode = (bool)$permissiveMode;

        $this->whitelistCheck = new WhitelistCheck();
        $this->blacklistCheck = new BlacklistCheck();
    }

    /**
     * @param array $definitions
     */
    public function whitelist(array $definitions)
    {
        $this->whitelistCheck->addDefinitions($definitions);
    }

    /**
     * @param array $definitions
     */
    public function blacklist(array $definitions)
    {
        $this->blacklistCheck->addDefinitions($definitions);
    }

    /**
     * @param $value
     * @return mixed
     */
    public function check($value)
    {
        $whitelistCheck = $this->whitelistCheck->getDefinitionsCount() > 0
            ? $this->whitelistCheck->check($value)
            : null;

        $blacklistCheck = $this->blacklistCheck->getDefinitionsCount() > 0
            ? $this->blacklistCheck->check($value)
            : null;

        // No rules set
        if ($whitelistCheck === null && $blacklistCheck === null) {
            return $this->permissiveMode;
        }

        // No whitelist set
        if ($whitelistCheck === null) {
            return $blacklistCheck;
        }

        // No blacklist set
        if ($blacklistCheck === null) {
            return $whitelistCheck;
        }

        // Both check must be true
        return $whitelistCheck && $blacklistCheck;
    }


}

function printBool($title, $value)
{
    echo $title . ': ' . ($value ? 'true' : 'false') . PHP_EOL;
}
