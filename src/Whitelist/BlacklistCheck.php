<?php
/**
 * BlacklistCheck.php
 *
 * @author cnastasi - Christian Nastasi <christian.nastasi@dxi.eu>
 * Created on Sep 29, 2015, 15:09
 * Copyright (C) DXI Ltd
 */

namespace Whitelist;

/**
 * Class BlacklistCheck
 * @package Whitelist
 */
class BlacklistCheck extends AbstractCheck
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function check($value)
    {
        return ! parent::check($value);
    }
}
