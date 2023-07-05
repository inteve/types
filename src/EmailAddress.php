<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class EmailAddress
	{
		/** @var string */
		private $emailAddress;


		public function __construct(string $emailAddress)
		{
			Assert::true(Validators::isEmail($emailAddress), 'Invalid email address.');
			$this->emailAddress = $emailAddress;
		}


		public function toString(): string
		{
			return $this->emailAddress;
		}


		public function __toString(): string
		{
			return $this->emailAddress;
		}
	}
