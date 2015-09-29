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
    public function __construct()
    {
        parent::__construct(true);
    }
}
