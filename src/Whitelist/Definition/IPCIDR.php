<?php

namespace Whitelist\Definition;

use Exception;
use IpUtils\Expression\ExpressionInterface;
use IpUtils\Expression\Subnet;
use IpUtils\Factory;

/**
 * Represents a CIDR notation
 *
 * @author Sam Stenvall <neggelandia@gmail.com>
 * @copyright Copyright &copy; Sam Stenvall 2014-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
abstract class IPCIDR extends Definition
{

    /**
     * @var ExpressionInterface
     */
    protected $_subnet;

    public function validate()
    {
        try {
            $this->_subnet = Factory::getExpression($this->_definition);

            // Check that we got a subnet expression and not something else
            if (! $this->_subnet instanceof Subnet) {
                return false;
            }
        } catch (Exception $e) {
            unset($e);

            return false;
        }

        return true;
    }

    public function match($value)
    {
        try {
            $address = Factory::getAddress($value);

            return $this->_subnet->matches($address);
        } catch (Exception $e) {
            unset($e);

            return false;
        }
    }

}
