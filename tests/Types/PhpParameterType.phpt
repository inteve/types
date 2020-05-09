<?php

use CzProject\Assert\AssertException;
use Inteve\Types\PhpParameterType;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$type = new PhpParameterType(PhpParameterType::class);
	Assert::same(PhpParameterType::class, $type->getType());
	Assert::same(PhpParameterType::class, (string) $type);
	Assert::false($type->isBasicType());

	$type = new PhpParameterType('bool');
	Assert::same('bool', $type->getType());
	Assert::same('bool', (string) $type);
	Assert::true($type->isBasicType());
});


test(function () {
	$type = new PhpParameterType('array');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('bool');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('float');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('int');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('string');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('self');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('iterable');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('callable');
	Assert::true($type->isBasicType());

	$type = new PhpParameterType('object');
	Assert::true($type->isBasicType());
});


test(function () {
	Assert::same(PhpParameterType::arrayType(), PhpParameterType::arrayType());
	Assert::same(PhpParameterType::boolType(), PhpParameterType::boolType());
	Assert::same(PhpParameterType::floatType(), PhpParameterType::floatType());
	Assert::same(PhpParameterType::intType(), PhpParameterType::intType());
	Assert::same(PhpParameterType::stringType(), PhpParameterType::stringType());
	Assert::same(PhpParameterType::selfType(), PhpParameterType::selfType());
	Assert::same(PhpParameterType::objectType(), PhpParameterType::objectType());
	Assert::same(PhpParameterType::iterableType(), PhpParameterType::iterableType());
	Assert::same(PhpParameterType::callableType(), PhpParameterType::callableType());
	Assert::same(PhpParameterType::classType(PhpParameterType::class), PhpParameterType::classType(PhpParameterType::class));
});


test(function () {
	Assert::exception(function () {
		new PhpParameterType('');
	}, AssertException::class, 'Type cannot be empty.');

	Assert::exception(function () {
		new PhpParameterType(40);
	}, AssertException::class, 'Invalid value type - expected string, integer given.');

	Assert::exception(function () {
		PhpParameterType::classType('bool');
	}, AssertException::class, 'Class type cannot be basic type.');
});
