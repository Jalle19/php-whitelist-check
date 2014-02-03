php-whitelist-check
===================

A modern and simple approach to validating IP addresses and domains against a whitelist. It supports both IPv4 and IPv6.

## Usage

The `Check::whitelist()` method takes an array of definitions which will constitute the whitelist. The definitions can either be strings (which will be parsed to their respective objects) or objects.

To create your own definition classes just extended `Whitelist\Definition\Definition` and implement `Whitelist\Definition\IDefinition`

Example usage:

```php
require_once("vendor/autoload.php");

$checker = new Whitelist\Check();

try {
	$checker->whitelist(array(
		'10.0.3.1',
		'10.0.0.0/16',
		'2001:14b8:100:934b::3:1',
		'2001:14b8:100:934b::/64',
		'*.example.com',
		new Whitelist\Definition\Domain('sub.example.com'),
	));
}
catch (InvalidArgumentException $e) {
	// thrown when an invalid definition is encountered
}

$checker->check('10.0.1.1'); // true
$checker->check('10.1.1.1'); // false
$checker->check('2001:14b8:100:934b::210:2'); // true
$checker->check('another.example.com'); // true

```

## Credits

This library depends on xrstf/ip-utils for the IP-related functionality. It also assumes that ip-utils's test cases are sufficient, which is why only trivial testing on these functions have been made for this library.
