<?php

use CzProject\Assert\AssertException;
use Inteve\Types\Md5;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$hash = md5('Lorem ipsum');

	$md5 = new Md5($hash);
	Assert::same($hash, $md5->getHash());
});


test(function () {
	$hash = strtoupper(md5('Lorem ipsum'));

	$md5 = new Md5($hash);
	Assert::same(strtolower($hash), $md5->getHash());
});


test(function () {
	$md5 = Md5::from('Lorem ipsum');
	Assert::same(md5('Lorem ipsum'), $md5->getHash());
});


test(function () {
	$md5 = Md5::fromFile(__DIR__ . '/fixtures/lorem-ipsum.txt');
	Assert::same(md5("Lorem ipsum\n"), $md5->getHash());
});


test(function () {
	Assert::exception(function () {
		$md5 = new Md5(10);
	}, AssertException::class, 'Invalid value type - expected string, integer given.');
});


test(function () {
	Assert::exception(function () {
		$md5 = new Md5('Invalid string');
	}, AssertException::class, 'Invalid hash.');
});
