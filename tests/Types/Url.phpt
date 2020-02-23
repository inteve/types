<?php

use CzProject\Assert\AssertException;
use Inteve\Types\Url;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$value = 'https://www.example.com/page/';
	$url = new Url($value);
	Assert::same($value, $url->getUrl());
	Assert::same($value, (string) $url);
});


test(function () {
	Assert::exception(function () {
		new Url('invalid url');
	}, AssertException::class, 'Invalid URL.');
});
