<?php

declare(strict_types=1);

use CzProject\Assert\AssertException;
use Inteve\Types\EmailAddress;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$value = 'john@doe.com';
	$emailAddress = new EmailAddress($value);
	Assert::same($value, $emailAddress->toString());
	Assert::same($value, (string) $emailAddress);
});


test(function () {
	Assert::exception(function () {
		new EmailAddress('invalid email');
	}, AssertException::class, 'Invalid email address.');
});
