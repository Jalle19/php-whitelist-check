<?php
/**
 * ICheck.php
 *
 * @author cnastasi - Christian Nastasi <christian.nastasi@dxi.eu>
 * Created on Sep 29, 2015, 14:08
 * Copyright (C) DXI Ltd
 */

namespace Whitelist;

/**
 * Class ICheck
 * @package Whitelist
 */
interface ICheck
{
    public function check($value);
}
