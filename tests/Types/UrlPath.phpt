<?php

use CzProject\Assert\AssertException;
use Inteve\Types\UrlPath;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$path = UrlPath::fromString('Hello/Gandalf The White!!!');

	Assert::same('hello/gandalf-the-white', $path->toString());

	$path2 = new UrlPath($path->toString());

	Assert::same($path->toString(), $path2->toString());
});


test(function () {
	$path = UrlPath::fromString('/');
	Assert::same('/', $path->toString());
	Assert::true($path->isRoot());
	Assert::same(0, $path->getLevel());
	Assert::same('/', $path->getBaseName());
	Assert::null($path->getDirectoryName());

	$path = UrlPath::fromString('/gandalf/');
	Assert::same('gandalf', $path->toString());
	Assert::false($path->isRoot());
	Assert::same(1, $path->getLevel());
	Assert::same('gandalf', $path->getBaseName());
	Assert::null($path->getDirectoryName());

	$path = UrlPath::fromString('/gandalf/the white');
	Assert::same('gandalf/the-white', $path->toString());
	Assert::false($path->isRoot());
	Assert::same(2, $path->getLevel());
	Assert::same('the-white', $path->getBaseName());
	Assert::same('gandalf', $path->getDirectoryName());
});


test(function () {
	Assert::noError(function () {
		new UrlPath('/');
		new UrlPath('a');
		new UrlPath('ab');
		new UrlPath('abc');
		new UrlPath('9');
		new UrlPath('98');
		new UrlPath('987');
		new UrlPath('9a8');
		new UrlPath('a9b');
		new UrlPath('a-9-b');
	});


	Assert::exception(function () {
		new UrlPath('invalid PATH');
	}, AssertException::class, 'Invalid path.');


	Assert::exception(function () {
		new UrlPath('-');
	}, AssertException::class, 'Invalid path.');


	Assert::exception(function () {
		new UrlPath('-a');
	}, AssertException::class, 'Invalid path.');


	Assert::exception(function () {
		new UrlPath('a-');
	}, AssertException::class, 'Invalid path.');
});
