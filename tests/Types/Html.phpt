<?php

declare(strict_types=1);

use CzProject\Assert\AssertException;
use Inteve\Types\Html;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$value = '<p>Lorem &gt; ipsum</p>';
	$html = new Html($value);
	Assert::same($value, $html->getHtml());
	Assert::same($value, (string) $html);
	Assert::same('Lorem > ipsum', $html->getPlainText());
});


test(function () {
	$html = Html::fromText("Hello\nGandalf!\n");
	Assert::same("Hello<br>\nGandalf!<br>\n", $html->getHtml());
});
