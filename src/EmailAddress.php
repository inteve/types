<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class EmailAddress
	{
		/** @var string */
		private $emailAddress;


		/**
		 * @param  string $emailAddress
		 */
		public function __construct($emailAddress)
		{
			Assert::string($emailAddress);
			Assert::true(Validators::isEmail($emailAddress), 'Invalid email address.');
			$this->emailAddress = $emailAddress;
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->emailAddress;
		}


		public function __toString()
		{
			return $this->emailAddress;
		}
	}
