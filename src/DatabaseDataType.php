<?php

	declare(strict_types=1);

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
		 * @param  mixed[] $parameters
		 * @param  array<string|int, mixed> $options  [OPTION => VALUE, OPTION2]
		 */
		public function __construct(string $type, array $parameters = [], array $options = [])
		{
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


		public function getType(): string
		{
			return $this->type;
		}


		/**
		 * @return mixed[]
		 */
		public function getParameters(): array
		{
			return $this->parameters;
		}


		public function hasParameters(): bool
		{
			return !empty($this->parameters);
		}


		/**
		 * @return array<string|int, mixed>
		 */
		public function getOptions(): array
		{
			return $this->options;
		}


		public function hasOption(string $option): bool
		{
			return array_key_exists($option, $this->options);
		}


		/**
		 * @return mixed|NULL
		 */
		public function getOptionValue(string $option)
		{
			if (!$this->hasOption($option)) {
				throw new \Inteve\Types\MissingException("Type hasn't option '$option'.");
			}

			return $this->options[$option];
		}
	}
