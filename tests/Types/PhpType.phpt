<?php

use CzProject\Assert\AssertException;
use Inteve\Types\PhpType;
use Inteve\Types\PhpParameterType;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$type = new PhpType(PhpType::class);
	Assert::same(PhpType::class, $type->getType());
	Assert::same(PhpType::class, (string) $type);
	Assert::false($type->isBasicType());

	$type = new PhpType('bool');
	Assert::same('bool', $type->getType());
	Assert::same('bool', (string) $type);
	Assert::true($type->isBasicType());
});


test(function () {
	$type = new PhpType('array');
	Assert::true($type->isBasicType());

	$type = new PhpType('bool');
	Assert::true($type->isBasicType());

	$type = new PhpType('float');
	Assert::true($type->isBasicType());

	$type = new PhpType('int');
	Assert::true($type->isBasicType());

	$type = new PhpType('string');
	Assert::true($type->isBasicType());
});


test(function () {
	Assert::same(PhpType::arrayType(), PhpType::arrayType());
	Assert::same(PhpType::boolType(), PhpType::boolType());
	Assert::same(PhpType::floatType(), PhpType::floatType());
	Assert::same(PhpType::intType(), PhpType::intType());
	Assert::same(PhpType::stringType(), PhpType::stringType());
	Assert::same(PhpType::classType(PhpType::class), PhpType::classType(PhpType::class));
});


test(function () {
	Assert::exception(function () {
		new PhpType('');
	}, AssertException::class, 'Type cannot be empty.');

	Assert::exception(function () {
		new PhpType(40);
	}, AssertException::class, 'Invalid value type - expected string, integer given.');

	Assert::exception(function () {
		PhpType::classType('bool');
	}, AssertException::class, 'Class type cannot be basic type.');
});


test(function () {
	Assert::same(PhpType::arrayType(), PhpType::fromParameterType(PhpParameterType::arrayType()));

	Assert::exception(function () {
		PhpType::fromParameterType(PhpParameterType::selfType());
	}, Inteve\Types\InvalidArgumentException::class, "Parameter type 'self' cannot be converted to Inteve\\Types\\PhpType.");

	Assert::exception(function () {
		PhpType::fromParameterType(PhpParameterType::objectType());
	}, Inteve\Types\InvalidArgumentException::class, "Parameter type 'object' cannot be converted to Inteve\\Types\\PhpType.");

	Assert::exception(function () {
		PhpType::fromParameterType(PhpParameterType::iterableType());
	}, Inteve\Types\InvalidArgumentException::class, "Parameter type 'iterable' cannot be converted to Inteve\\Types\\PhpType.");

	Assert::exception(function () {
		PhpType::fromParameterType(PhpParameterType::callableType());
	}, Inteve\Types\InvalidArgumentException::class, "Parameter type 'callable' cannot be converted to Inteve\\Types\\PhpType.");
});
