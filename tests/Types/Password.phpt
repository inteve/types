<?php

use Inteve\Types\Password;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$password = Password::hash('12345');

	Assert::true($password->verify('12345'));
	Assert::false($password->verify('54321'));

	$password2 = new Password($password->getHash());

	Assert::true($password2->verify('12345'));
	Assert::false($password2->verify('54321'));
});
