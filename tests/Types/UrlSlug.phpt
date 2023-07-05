<?php

declare(strict_types=1);

use CzProject\Assert\AssertException;
use Inteve\Types\UrlSlug;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$slug = UrlSlug::fromString('Hello Gandalf!!');

	Assert::same('hello-gandalf', $slug->toString());

	$slug2 = new UrlSlug($slug->toString());

	Assert::same($slug->toString(), $slug2->toString());
});


test(function () {
	Assert::exception(function () {
		new UrlSlug('invalid SLUG');
	}, AssertException::class, 'Invalid slug.');
});
