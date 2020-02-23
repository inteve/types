<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class Md5Hash
	{
		/** @var string */
		private $hash;


		/**
		 * @param  string
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
		 * @param  string
		 * @return static
		 */
		public static function from($s)
		{
			Assert::string($s);
			return new static(md5($s));
		}


		/**
		 * @param  string
		 * @return static
		 */
		public static function fromFile($path)
		{
			Assert::string($path);
			return new static(md5_file($path));
		}
	}
