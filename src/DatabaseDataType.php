<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class DatabaseDataType
	{
		/** @var string */
		private $type;

		/** @var mixed[] */
		private $parameters;

		/** @var array<string|int, mixed> */
		private $options = [];


		/**
		 * @param  string $type
		 * @param  mixed[] $parameters
		 * @param  array<string|int, mixed> $options  [OPTION => VALUE, OPTION2]
		 */
		public function __construct($type, array $parameters = [], array $options = [])
		{
			Assert::string($type);
			$type = trim($type);
			Assert::true($type !== '', 'Type cannot be empty.');

			$this->type = $type;
			$this->parameters = $parameters;

			foreach ($options as $k => $v) {
				if (is_int($k)) {
					$this->options[$v] = NULL;

				} else {
					$this->options[$k] = $v;
				}
			}
		}


		/**
		 * @return string
		 */
		public function getType()
		{
			return $this->type;
		}


		/**
		 * @return mixed[]
		 */
		public function getParameters()
		{
			return $this->parameters;
		}


		/**
		 * @return bool
		 */
		public function hasParameters()
		{
			return !empty($this->parameters);
		}


		/**
		 * @return array<string|int, mixed>
		 */
		public function getOptions()
		{
			return $this->options;
		}


		/**
		 * @param string $option
		 * @return bool
		 */
		public function hasOption($option)
		{
			return array_key_exists($option, $this->options);
		}


		/**
		 * @param string $option
		 * @return mixed|NULL
		 */
		public function getOptionValue($option)
		{
			if (!$this->hasOption($option)) {
				throw new \Inteve\Types\MissingException("Type hasn't option '$option'.");
			}

			return $this->options[$option];
		}
	}
