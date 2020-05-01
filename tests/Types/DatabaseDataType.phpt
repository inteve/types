<?php

use CzProject\Assert\AssertException;
use Inteve\Types\DatabaseDataType;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$type = new DatabaseDataType('varchar');
	Assert::same('varchar', $type->getType());
	Assert::same([], $type->getParameters());
	Assert::false($type->hasParameters());
	Assert::same([], $type->getOptions());
	Assert::false($type->hasOption('UNSIGNED'));

	$type = new DatabaseDataType('INT', [1], ['UNSIGNED']);
	Assert::same('INT', $type->getType());
	Assert::same([1], $type->getParameters());
	Assert::true($type->hasParameters());
	Assert::same(['UNSIGNED' => NULL], $type->getOptions());
	Assert::true($type->hasOption('UNSIGNED'));
	Assert::null($type->getOptionValue('UNSIGNED'));
});


test(function () {
	$type = new DatabaseDataType('INT', [1], [
		'COLLATE' => 'utf8',
		'UNSIGNED',
	]);

	Assert::true($type->hasOption('COLLATE'));
	Assert::true($type->hasOption('UNSIGNED'));

	Assert::same('utf8', $type->getOptionValue('COLLATE'));
	Assert::null($type->getOptionValue('UNSIGNED'));

	Assert::exception(function () use ($type) {
		$type->getOptionValue('unknow');
	}, Inteve\Types\MissingException::class, "Type hasn't option 'unknow'.");
});


test(function () {
	Assert::exception(function () {
		new DatabaseDataType('');
	}, AssertException::class, 'Type cannot be empty.');

	Assert::exception(function () {
		new DatabaseDataType(40);
	}, AssertException::class, 'Invalid value type - expected string, integer given.');
});
