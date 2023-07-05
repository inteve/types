<?php

declare(strict_types=1);

use CzProject\Assert\AssertException;
use Inteve\Types\HexColor;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$color = new HexColor('0088ff');
	Assert::same('0088ff', $color->getValue());
});


test(function () {
	$color = new HexColor('aaBbCC');
	Assert::same('aabbcc', $color->getValue());
});


test(function () {
	$color = HexColor::fromCssColor('#0088FF');
	Assert::same('#0088ff', $color->getCssValue());
});


test(function () {
	Assert::exception(function () {
		$color = new HexColor('Invalid string');
	}, AssertException::class, 'Invalid color value.');
});


test(function () {
	Assert::exception(function () {
		$color = HexColor::fromCssColor('Invalid string');
	}, AssertException::class, 'Invalid CSS color.');
});
