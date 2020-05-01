<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class DatabaseDataType
	{
		/** @var string */
		private $type;

		/** @var array */
		private $parameters;

		/** @var array */
		private $options = [];


		/**
		 * @param  string
		 * @param  array|string
		 * @param  array  [OPTION => VALUE, OPTION2]
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
		 * @return array
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
		 * @return array
		 */
		public function getOptions()
		{
			return $this->options;
		}


		/**
		 * @return bool
		 */
		public function hasOption($option)
		{
			return array_key_exists($option, $this->options);
		}


		/**
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
