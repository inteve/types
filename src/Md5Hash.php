<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class Md5Hash
	{
		/** @var string */
		private $hash;


		/**
		 * @param  string $hash
		 */
		public function __construct($hash)
		{
			Assert::string($hash);
			$hash = strtolower($hash);
			Assert::true(strlen($hash) === 32 && ctype_xdigit($hash), 'Invalid hash.');
			$this->hash = $hash;
		}


		/**
		 * @return string
		 */
		public function getHash()
		{
			return $this->hash;
		}


		/**
		 * @param  string $s
		 * @return self
		 */
		public static function from($s)
		{
			Assert::string($s);
			return new self(md5($s));
		}


		/**
		 * @param  string $path
		 * @return self
		 */
		public static function fromFile($path)
		{
			Assert::string($path);
			return new self((string) md5_file($path));
		}
	}
