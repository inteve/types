<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use Nette\Utils\Validators;


	class Decimal
	{
		/** @var numeric-string */
		private $value;

		/** @var int */
		private $decimals;

		/** @var bool */
		private $zero;


		/**
		 * @param numeric-string $value
		 */
		public function __construct(string $value)
		{
			if (!Validators::isNumeric($value)) {
				throw new InvalidArgumentException('Value must be numeric.');
			}

			$value = ltrim($value, '0');

			if ($value === '') {
				$value = '0';

			} elseif ($value[0] === '.') {
				$value = '0' . $value;
			}

			if (!is_numeric($value)) {
				throw new InvalidArgumentException('Value is not valid numeric string.');
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


		public function isZero(): bool
		{
			return $this->zero;
		}


		public function plus(Decimal $b, ?int $decimals = NULL): self
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcadd($this->value, $b->value, $decimals + 1);
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		public function minus(Decimal $b, ?int $decimals = NULL): self
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcsub($this->value, $b->value, $decimals + 1);
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		public function multipleBy(Decimal $b, ?int $decimals = NULL): self
		{
			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcmul($this->value, $b->value, $decimals + 1);
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		public function divideBy(Decimal $b, ?int $decimals = NULL): self
		{
			if ($b->isZero()) {
				throw new InvalidArgumentException('Division by zero.');
			}

			$hasDecimals = $decimals !== NULL;
			$decimals = $decimals !== NULL ? $decimals : max($this->decimals, $b->decimals);
			$newValue = bcdiv($this->value, $b->value, $decimals + 1);
			return new self(self::roundResult($newValue, $decimals, $hasDecimals));
		}


		public function toString(): string
		{
			return $this->value;
		}


		/**
		 * @param  string|int|float $value
		 */
		public static function from($value, ?int $decimals = NULL): self
		{
			if ($decimals !== NULL) {
				if (is_string($value)) {
					throw new InvalidArgumentException("Parameter 'decimals' has no effect for value of type 'string'.");
				}

				$value = number_format($value, $decimals, '.', '');
			}

			$value = (string) $value;

			if (!is_numeric($value)) {
				throw new InvalidArgumentException("Value is not numeric-string.");
			}

			return new self($value);
		}


		/**
		 * @param  numeric-string $newValue
		 * @return numeric-string
		 */
		private static function roundResult(string $newValue, int $decimals, bool $hasDecimals): string
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

				$num2 = '0.' . str_repeat('0', $decimals) . '5';
				assert(is_numeric($num2));

				if (str_starts_with($newValue[0], '-')) { // negative
					$newValue = bcsub($newValue, $num2, $decimals);

				} else {
					$newValue = bcadd($newValue, $num2, $decimals);
				}

			} else {
				$newValue = rtrim(substr($newValue, 0, -1), '.');
			}


			if (!is_numeric($newValue)) {
				throw new InvalidStateException("Rounded value is not numeric-string.");
			}

			return $newValue;
		}
	}
