<?php

use CzProject\Assert\AssertException;
use Inteve\Types\UniqueId;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$id = UniqueId::create();
	$id2 = new UniqueId($id->toString());

	Assert::same($id->toString(), $id2->toString());
});


test(function () {
	Assert::exception(function () {
		new UniqueId('invalid ID');
	}, AssertException::class, 'Invalid ID.');
});
