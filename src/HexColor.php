<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class HexColor
	{
		/** @var string */
		private $value;


		/**
		 * @param  string
		 */
		public function __construct($value)
		{
			Assert::string($value);
			$value = strtolower($value);
			Assert::true(strlen($value) === 6 && ctype_xdigit($value), 'Invalid color value.');
			$this->value = $value;
		}


		/**
		 * @return string
		 */
		public function getValue()
		{
			return $this->value;
		}


		/**
		 * @return string
		 */
		public function getCssValue()
		{
			return '#' . $this->value;
		}


		/**
		 * @param  string
		 * @return static
		 */
		public static function fromCssColor($color)
		{
			Assert::string($color);
			Assert::true(strlen($color) === 7 && $color[0] === '#', 'Invalid CSS color.');
			return new static(substr($color, 1));
		}
	}
