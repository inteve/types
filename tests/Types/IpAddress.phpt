<?php

declare(strict_types=1);

use CzProject\Assert\AssertException;
use Inteve\Types\IpAddress;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$value = '127.0.0.1';
	$ipAddress = new IpAddress($value);
	Assert::same($value, $ipAddress->toString());
	Assert::same($value, (string) $ipAddress);
});


test(function () {
	Assert::exception(function () {
		new IpAddress('invalid ip');
	}, AssertException::class, 'Invalid IP address.');
});


test(function () { // host vs IP address
	Assert::false(IpAddress::isValid(''));
	Assert::false(IpAddress::isValid('hello'));
	Assert::false(IpAddress::isValid('inteve.org'));
	Assert::false(IpAddress::isValid('inteve.org0'));
	Assert::false(IpAddress::isValid('inteve.0org'));
	Assert::false(IpAddress::isValid('_inteve.org'));
	Assert::false(IpAddress::isValid('www._inteve.org'));
	Assert::false(IpAddress::isValid('www.ne_tte.org'));
	Assert::false(IpAddress::isValid('1.org'));
	Assert::false(IpAddress::isValid('l.org'));
	Assert::false(IpAddress::isValid('localhost'));
	Assert::true(IpAddress::isValid('127.0.0.1'));
	Assert::false(IpAddress::isValid('127.0.0'));
	Assert::false(IpAddress::isValid('127'));
	Assert::true(IpAddress::isValid('::1'));
	Assert::true(IpAddress::isValid('2001:0db8:0000:0000:0000:0000:1428:57AB'));
	Assert::true(IpAddress::isValid('2001:0718:1c01:0016:0214:22ff:fec9:0ca5'));
	Assert::true(IpAddress::isValid('2001:718:1c01:16:214:22ff:fec9:ca5'));
	Assert::true(IpAddress::isValid('2001:db8:0:1234:0:567:8:1'));
	Assert::true(IpAddress::isValid('2001:0db8:85a3:0000:0000:8a2e:0370:7334'));
	Assert::true(IpAddress::isValid('2001:db8::1:0:0:1'));
	Assert::false(IpAddress::isValid('inteve.cz'));
	Assert::false(IpAddress::isValid('inteve.cz:8080'));
	Assert::false(IpAddress::isValid('example.c0m'));
	Assert::false(IpAddress::isValid('example.l'));
	Assert::false(IpAddress::isValid('one_two.example.com'));
	Assert::false(IpAddress::isValid('_.example.com'));
	Assert::false(IpAddress::isValid('_e_.example.com'));
});


test(function () { // URI
	Assert::false(IpAddress::isValid(''));
	Assert::false(IpAddress::isValid('hello'));
	Assert::false(IpAddress::isValid('inteve.cz'));
	Assert::false(IpAddress::isValid('mailto: gandalf@example.org'));
	Assert::false(IpAddress::isValid('invalid-scheme :gandalf@example.org'));
	Assert::false(IpAddress::isValid('invalid-scheme~:gandalf@example.org'));
	Assert::false(IpAddress::isValid('mailto:gandalf@example.org'));
	Assert::false(IpAddress::isValid('valid-scheme+.0:lalala'));
	Assert::false(IpAddress::isValid('bitcoin:mipcBbFg9gMiCh81Kj8tqqdgoZub1ZJRfn'));
});


test(function () { // IPV4
	Assert::false(IpAddress::isValid('256.0.0.1'));
	Assert::true(IpAddress::isValid('0.0.0.0'));
});


test(function () { // examples https://datatracker.ietf.org/doc/html/rfc5952#section-1
	Assert::true(IpAddress::isValidIpv6('2001:db8:0:0:1:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8:0:0:1:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8::1:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8::0:1:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8::1:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0:0:1::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0000:0:1::1'));
	Assert::true(IpAddress::isValidIpv6('2001:DB8:0:0:1::1'));
});


test(function () { // https://datatracker.ietf.org/doc/html/rfc5952#section-2.1
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd:eeee:0001'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd:eeee:001'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd:eeee:01'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd:eeee:1'));
});


test(function () { // https://datatracker.ietf.org/doc/html/rfc5952#section-2.2
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:aaaa:bbbb:cccc:dddd:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0:0:0::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0:0::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8::1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8::aaaa:0:0:1'));
	Assert::true(IpAddress::isValidIpv6('2001:db8:0:0:aaaa::1'));

	Assert::false(IpAddress::isValidIpv6('2001::db8:0:0:aaaa::1')); // invalid - more ::
});


test(function () { // wikipedia
	Assert::true(IpAddress::isValidIpv6('2001:0db8:0000:0000:0000:0000:1428:57ab'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8:0000:0000:0000::1428:57ab'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8:0:0:0:0:1428:57ab'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8:0:0::1428:57ab'));
	Assert::true(IpAddress::isValidIpv6('2001:0db8::1428:57ab'));
	Assert::true(IpAddress::isValidIpv6('2001:db8::1428:57ab'));
});


test(function () { // invalid
	Assert::false(IpAddress::isValidIpv6('2001:0db8:0000:0000:0000:0000:1428:57ab:0000')); // too long
});
