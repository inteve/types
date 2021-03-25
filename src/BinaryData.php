<?php

	namespace Inteve\Types;


	class BinaryData
	{
		/** @var string */
		private $data;


		/**
		 * @param string $data
		 */
		public function __construct($data)
		{
			if (!is_string($data)) {
				throw new InvalidArgumentException('Data must be string.');
			}

			if ($data === '') {
				throw new InvalidArgumentException('Data cannot be empty.');
			}

			$this->data = $data;
		}


		/**
		 * @return string
		 */
		public function getData()
		{
			return $this->data;
		}


		/**
		 * @param  string $data
		 * @return self
		 */
		public static function fromBase64($data)
		{
			$binary = base64_decode($data, TRUE);

			if (!is_string($binary)) {
				throw new InvalidArgumentException('Invalid base64 data, base64_decode() failed.');
			}

			return new self($binary);
		}
	}
