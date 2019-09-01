<?php

use CzProject\Assert\AssertException;
use Inteve\Types\Html;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$html = '<p>Lorem &gt; ipsum</p>';
	$color = new Html($html);
	Assert::same($html, $color->getHtml());
	Assert::same($html, (string) $color);
	Assert::same('Lorem > ipsum', $color->getPlainText());
});
