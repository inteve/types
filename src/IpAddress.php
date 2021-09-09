<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class IpAddress
	{
		/** @var string */
		private $ipAddress;


		/**
		 * @param  string $ipAddress
		 */
		public function __construct($ipAddress)
		{
			Assert::string($ipAddress);
			Assert::true(self::isValid($ipAddress), 'Invalid IP address.');
			$this->ipAddress = $ipAddress;
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->ipAddress;
		}


		public function __toString()
		{
			return $this->ipAddress;
		}


		/**
		 * @param  string $value
		 * @return bool
		 */
		public static function isValid($value)
		{
			return self::isValidIpv4($value) || self::isValidIpv6($value);
		}


		/**
		 * @param  string $value
		 * @return bool
		 */
		public static function isValidIpv4($value)
		{
			if (!is_string($value)) {
				return FALSE;
			}

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


		/**
		 * @param  string $value
		 * @return bool
		 */
		public static function isValidIpv6($value)
		{
			if (!is_string($value)) {
				return FALSE;
			}

			if (strpos($value, ':') === FALSE) {
				return FALSE;
			}

			if (substr_count($value, '::') > 1) {
				return FALSE;
			}

			return (bool) preg_match("(^([0-9a-f:]{3,39})\\z)ix", $value);
		}
	}
