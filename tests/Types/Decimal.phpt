<?php

declare(strict_types=1);

use Inteve\Types\InvalidArgumentException;
use Inteve\Types\Decimal;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	Assert::same('-0.1', Decimal::from('-0.1')->toString());
	Assert::same('-0.1', Decimal::from(-0.1)->toString());
	Assert::same('-1', Decimal::from(-1)->toString());

	Assert::same('0.1', Decimal::from('0.1')->toString());
	Assert::same('0.1', Decimal::from(0.1)->toString());
	Assert::same('1', Decimal::from(1)->toString());
});


test(function () {
	Assert::same('0.0', Decimal::from('0.1')->plus(Decimal::from('0.2'))->minus(Decimal::from('0.3'))->toString());
	Assert::same('0', Decimal::from('1')->plus(Decimal::from('2'))->minus(Decimal::from('3'))->toString());
	Assert::same('6', Decimal::from('1')->plus(Decimal::from('2'))->minus(Decimal::from('-3'))->toString());

	Assert::same('-0.1', Decimal::from('0.1')->plus(Decimal::from('-0.2'))->toString());

	Assert::same('30.375', Decimal::from('10.125')->multipleBy(Decimal::from('3'))->toString());

	Assert::same('3.375', Decimal::from('10.125')->divideBy(Decimal::from('3'))->toString());

	Assert::same('1.0', Decimal::from('3')->divideBy(Decimal::from('3.0'))->toString());
	Assert::same('1', Decimal::from('3')->divideBy(Decimal::from('3.0'), 0)->toString());

	Assert::same('1.333', Decimal::from('4')->divideBy(Decimal::from('3'), 3)->toString());

	Assert::exception(function () {
		Assert::same('1', Decimal::from('4')->divideBy(Decimal::from('3'))->toString());
	}, InvalidArgumentException::class, 'Too much decimal places - please specify decimals manually.');

	Assert::exception(function () {
		Assert::same('0.667', Decimal::from('2')->divideBy(Decimal::from('3'))->toString());
	}, InvalidArgumentException::class, 'Too much decimal places - please specify decimals manually.');

	Assert::same('0.667', Decimal::from('2')->divideBy(Decimal::from('3'), 3)->toString());
	Assert::same('0.7', Decimal::from('2')->divideBy(Decimal::from('3'), 1)->toString());
	Assert::same('1', Decimal::from('2')->divideBy(Decimal::from('3'), 0)->toString());

	Assert::exception(function () {
		Decimal::from('2')->divideBy(Decimal::from('0.0'));
	}, InvalidArgumentException::class, 'Division by zero.');
});


test(function () {
	Assert::same('0.52', Decimal::from('0.22')->plus(Decimal::from('0.3'))->toString());
	Assert::same('0.5', Decimal::from('0.22')->plus(Decimal::from('0.3'), 1)->toString());
	Assert::same('1', Decimal::from('0.22')->plus(Decimal::from('0.3'), 0)->toString());

	Assert::same('0.59', Decimal::from('0.29')->plus(Decimal::from('0.3'))->toString());
	Assert::same('0.6', Decimal::from('0.29')->plus(Decimal::from('0.3'), 1)->toString());
	Assert::same('1', Decimal::from('0.29')->plus(Decimal::from('0.3'), 0)->toString());

	Assert::same('1.000', Decimal::from('0')->plus(Decimal::from('1'), 3)->toString());
});


test(function () {
	Assert::same('0', Decimal::from(0)->toString());
	Assert::same('0.00', Decimal::from(0, 2)->toString());
	Assert::same('0.67', Decimal::from(0.666, 2)->toString());
	Assert::same('0.7', Decimal::from(0.666, 1)->toString());
	Assert::same('1', Decimal::from(0.666, 0)->toString());
	Assert::same('0.11', Decimal::from(0.111, 2)->toString());

	// Assert::same('0', Decimal::from('0')->toString());
	// Assert::same('0.00', Decimal::from('0', 2)->toString());
	// Assert::same('0.67', Decimal::from('0.666', 2)->toString());
	// Assert::same('0.7', Decimal::from('0.666', 1)->toString());
	// Assert::same('1', Decimal::from('0.666', 0)->toString());
	// Assert::same('0.11', Decimal::from('0.111', 2)->toString());
});


test(function () {
	Assert::same('0', Decimal::from('00')->toString());
	Assert::same('0.00', Decimal::from('00.00')->toString());
	Assert::same('1.00', Decimal::from('01.00')->toString());
});


test(function () {
	Assert::true(Decimal::from('0')->isZero());
	Assert::true(Decimal::from('-0')->isZero());
	Assert::true(Decimal::from('0.00')->isZero());
	Assert::true(Decimal::from('-0.00')->isZero());
	Assert::false(Decimal::from('0.1')->isZero());
	Assert::false(Decimal::from('0.01')->isZero());
});


test(function () {
	Assert::exception(function () {
		new Decimal('hello');
	}, InvalidArgumentException::class, 'Value must be numeric.');
});
