php-safelist-check
===================

This is a fork of https://github.com/Jalle19/php-whitelist-check to change hidden bias terminology.

A modern and simple approach to validating IP addresses and domains against a safelist. It supports both IPv4 and IPv6 addresses and CIDR subnets in addition to domain names and wild-card domains.

## Requirements

* PHP 5.3 or newer

## Usage

The `Check::safelist()` method takes an array of definitions which will constitute the safelist. The definitions can either be strings (which will be parsed to their respective objects) or objects.

The `Check::check($value)` method is used to check the specified value against the current safelist. The method will return true if the value matches any of the definitions.

To create your own definition classes just extended `Safelist\Definition\Definition` and implement `Safelist\Definition\IDefinition`

Example usage:

```php
require_once("vendor/autoload.php");

$checker = new Safelist\Check();

try {
	$checker->safelist(array(
		'10.0.3.1',
		'10.0.0.0/16',
		'2001:db8:100:934b::3:1',
		'2001:db8:100:934b::/64',
		'*.example.com',
		'localhost',
		new Safelist\Definition\Domain('vpn.work.com'),
	));
}
catch (InvalidArgumentException $e) {
	// thrown when an invalid definition is encountered
}

$checker->check('10.0.1.1'); // true
$checker->check('10.1.1.1'); // false
$checker->check('2001:db8:100:934b::210:2'); // true
$checker->check('another.example.com'); // true

```

## License

This library is licensed under the BSD 2-Clause License

## Credits

This library depends on `xrstf/ip-utils` for the IP-related functionality. It also assumes that ip-utils's test cases are sufficient, which is why only trivial testing on these functions have been made for this library.
