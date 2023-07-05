<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class IpAddress
	{
		/** @var string */
		private $ipAddress;


		public function __construct(string $ipAddress)
		{
			Assert::true(self::isValid($ipAddress), 'Invalid IP address.');
			$this->ipAddress = $ipAddress;
		}


		public function toString(): string
		{
			return $this->ipAddress;
		}


		public function __toString(): string
		{
			return $this->ipAddress;
		}


		public static function isValid(string $value): bool
		{
			return self::isValidIpv4($value) || self::isValidIpv6($value);
		}


		public static function isValidIpv4(string $value): bool
		{
			if (!preg_match("(^\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\.\\d{1,3}\\z)ix", $value)) {
				return FALSE;
			}

			$parts = explode('.', $value);

			foreach ($parts as $part) {
				$part = (int) $part;

				if ($part > 255) {
					return FALSE;
				}
			}

			return TRUE;
		}


		public static function isValidIpv6(string $value): bool
		{
			if (strpos($value, ':') === FALSE) {
				return FALSE;
			}

			if (substr_count($value, '::') > 1) {
				return FALSE;
			}

			return (bool) preg_match("(^([0-9a-f:]{3,39})\\z)ix", $value);
		}
	}
