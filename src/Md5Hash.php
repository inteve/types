<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class Md5Hash
	{
		/** @var string */
		private $hash;


		public function __construct(string $hash)
		{
			$hash = strtolower($hash);
			Assert::true(strlen($hash) === 32 && ctype_xdigit($hash), 'Invalid hash.');
			$this->hash = $hash;
		}


		public function getHash(): string
		{
			return $this->hash;
		}


		public static function from(string $s): self
		{
			return new self(md5($s));
		}


		public static function fromFile(string $path): self
		{
			return new self((string) md5_file($path));
		}
	}
