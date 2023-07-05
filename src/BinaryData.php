<?php

	declare(strict_types=1);

	namespace Inteve\Types;


	class BinaryData
	{
		/** @var string */
		private $data;


		public function __construct(string $data)
		{
			if ($data === '') {
				throw new InvalidArgumentException('Data cannot be empty.');
			}

			$this->data = $data;
		}


		public function getData(): string
		{
			return $this->data;
		}


		public static function fromBase64(string $data): self
		{
			$binary = base64_decode($data, TRUE);

			if (!is_string($binary)) {
				throw new InvalidArgumentException('Invalid base64 data, base64_decode() failed.');
			}

			return new self($binary);
		}
	}
