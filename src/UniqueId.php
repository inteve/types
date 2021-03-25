<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Random;
	use Nette\Utils\Strings;


	class UniqueId
	{
		/** @var string */
		private $id;


		/**
		 * @param  string $id
		 */
		public function __construct($id)
		{
			Assert::string($id);
			Assert::true((bool) Strings::match($id, '~[0-9a-z]{10}~'), 'Invalid ID.');
			$this->id = $id;
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->id;
		}


		/**
		 * @return self
		 */
		public static function create()
		{
			return new self(Random::generate(10));
		}
	}
