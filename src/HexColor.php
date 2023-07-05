<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class HexColor
	{
		/** @var string */
		private $value;


		public function __construct(string $value)
		{
			$value = strtolower($value);
			Assert::true(strlen($value) === 6 && ctype_xdigit($value), 'Invalid color value.');
			$this->value = $value;
		}


		public function getValue(): string
		{
			return $this->value;
		}


		public function getCssValue(): string
		{
			return '#' . $this->value;
		}


		public static function fromCssColor(string $color): self
		{
			Assert::true(strlen($color) === 7 && $color[0] === '#', 'Invalid CSS color.');
			return new self(substr($color, 1));
		}
	}
