<?php

use Inteve\Types\Password;
use Inteve\Types\TypeSerializer;
use Tester\Assert;

require __DIR__ . '/../bootstrap.php';


test(function () {
	$html = TypeSerializer::readHtml('<br>');
	Assert::same('<br>', TypeSerializer::writeHtml($html));

	$md5hash = TypeSerializer::readMd5Hash('123456789a123456789a123456789abc');
	Assert::same('123456789a123456789a123456789abc', TypeSerializer::writeMd5Hash($md5hash));

	$origPassword = Password::hash('12345');
	$password = TypeSerializer::readPassword($origPassword->getHash());
	Assert::same($origPassword->getHash(), TypeSerializer::writePassword($password));

	$urlPath = TypeSerializer::readUrlPath('gandalf');
	Assert::same('gandalf', TypeSerializer::writeUrlPath($urlPath));

	$urlSlug = TypeSerializer::readUrlSlug('gandalf');
	Assert::same('gandalf', TypeSerializer::writeUrlSlug($urlSlug));

	$uniqueId = TypeSerializer::readUniqueId('abcdefghij');
	Assert::same('abcdefghij', TypeSerializer::writeUniqueId($uniqueId));
});
