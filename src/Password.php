<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class Password
	{
		/** @var string */
		private $hash;


		public function __construct(string $hash)
		{
			Assert::true(strlen($hash) >= 60, 'Invalid hash.');
			$this->hash = $hash;
		}


		public function getHash(): string
		{
			return $this->hash;
		}


		public function verify(string $password): bool
		{
			return password_verify($password, $this->hash);
		}


		/**
		 * @param  string|int $algo
		 * @param  array<string, mixed> $options
		 */
		public function needsRehash($algo = PASSWORD_BCRYPT, array $options = []): bool
		{
			return password_needs_rehash($this->hash, $algo, $options);
		}


		/**
		 * @param  string|int $algo
		 * @param  array<string, mixed> $options
		 */
		public static function hash(string $password, $algo = PASSWORD_BCRYPT, array $options = []): self
		{
			Assert::string($password);

			if ($password === '') {
				throw new InvalidArgumentException('Password can not be empty.');
			}

			$hash = @password_hash($password, $algo, $options); // @ is escalated to exception

			if (!$hash) {
				$lastError = error_get_last();
				throw new InvalidStateException('Computed hash is invalid. ' . ($lastError !== NULL ? $lastError['message'] : ''));
			}

			return new self($hash);
		}
	}
