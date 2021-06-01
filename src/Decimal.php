<?php

	namespace Inteve\Types;

	use Nette\Utils\Strings;
	use Nette\Utils\Validators;


	class Decimal
	{
		/** @var string */
		private $value;

		/** @var int */
		private $decimals;

		/** @var bool */
		private $zero;


		/**
		 * @param string $value
		 */
		public function __construct($value)
		{
			if (!is_string($value)) {
				throw new InvalidArgumentException('Value must be string, ' . gettype($value) . ' given.');
			}

			if (!Validators::isNumeric($value)) {
				throw new InvalidArgumentException('Value must be numeric.');
			}

			$value = ltrim($value, '0');

			if ($value === '') {
				$value = '0';

			} elseif ($value[0] === '.') {
				$value = '0' . $value;
			}

			$this->value = $value;
			$this->decimals = 0;

			if (($pos = strpos($value, '.')) !== FALSE) {
				$this->decimals = strlen($value) - $pos - 1;
			}

			$zeroValue = ltrim($this->value, '-');
			$zeroValue = trim($zeroValue, '0');
			$zeroValue = ltrim($zeroValue, '.');
			$this->zero = $zeroValue === '';
		}


		/**
		 * @return bool
		 */
		public function isZero()
		{
			return $this->zero;
		}


		/**
		 * @param  int|NULL $decimals
		 * @return self
		 */
		public function plus(Decimal $b, $decimals = NULL)
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcadd($this->value, $b->value, $decimals + 1);
			assert($newValue !== NULL); // PHPStan fix
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		/**
		 * @param  int|NULL $decimals
		 * @return self
		 */
		public function minus(Decimal $b, $decimals = NULL)
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcsub($this->value, $b->value, $decimals + 1);
			assert($newValue !== NULL); // PHPStan fix
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		/**
		 * @param  int|NULL $decimals
		 * @return self
		 */
		public function multipleBy(Decimal $b, $decimals = NULL)
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcmul($this->value, $b->value, $decimals + 1);
			assert($newValue !== NULL); // PHPStan fix
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		/**
		 * @param  int|NULL $decimals
		 * @return self
		 */
		public function divideBy(Decimal $b, $decimals = NULL)
		{
			if ($b->isZero()) {
				throw new InvalidArgumentException('Division by zero.');
			}

			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcdiv($this->value, $b->value, $decimals + 1);
			assert($newValue !== NULL); // PHPStan fix
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->value;
		}


		/**
		 * @param  string|int|float $value
		 * @param  int|NULL $decimals
		 * @return self
		 */
		public static function from($value, $decimals = NULL)
		{
			if ($decimals !== NULL) {
				if (is_string($value)) {
					throw new InvalidArgumentException("Parameter 'decimals' has no effect for value of type 'string'.");
				}

				$value = number_format($value, $decimals, '.', '');
			}

			return new self((string) $value);
		}


		/**
		 * @param  string $newValue
		 * @param  int $decimals
		 * @param  bool $hasDecimals
		 * @return string
		 */
		private static function roundResult($newValue, $decimals, $hasDecimals)
		{
			$pos = strpos($newValue, '.');
			$newDecimals = $pos !== FALSE ? (strlen($newValue) - ($pos + 1)) : 0;

			if ($newDecimals <= $decimals) {
				return $newValue;
			}

			$ending = substr($newValue, -1);

			if ($ending !== '0') {
				if (!$hasDecimals) {
					throw new InvalidArgumentException('Too much decimal places - please specify decimals manually.');
				}

				if (Strings::startsWith($newValue[0], '-')) { // negative
					$newValue = bcsub($newValue, '0.' . str_repeat('0', $decimals) . '5', $decimals);

				} else {
					$newValue = bcadd($newValue, '0.' . str_repeat('0', $decimals) . '5', $decimals);
				}

			} else {
				$newValue = rtrim(substr($newValue, 0, -1), '.');
			}

			return $newValue;
		}
	}
