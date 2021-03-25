<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Security\Passwords;


	class Password
	{
		/** @var string */
		private $hash;


		/**
		 * @param  string $hash
		 */
		public function __construct($hash)
		{
			Assert::string($hash);
			Assert::true(strlen($hash) >= 60, 'Invalid hash.');
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
		 * @param  string $password
		 * @return bool
		 */
		public function verify($password)
		{
			return Passwords::verify($password, $this->hash);
		}


		/**
		 * @return bool
		 */
		public function needsRehash()
		{
			return Passwords::needsRehash($this->hash);
		}


		/**
		 * @param  string $password
		 * @return self
		 */
		public static function hash($password)
		{
			Assert::string($password);
			return new self(Passwords::hash($password));
		}
	}
