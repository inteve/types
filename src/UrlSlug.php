<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Strings;


	class UrlSlug
	{
		/** @var string */
		private $slug;


		/**
		 * @param  string $slug
		 */
		public function __construct($slug)
		{
			Assert::string($slug);
			Assert::true((bool) Strings::match($slug, '~^[0-9a-z]([0-9a-z-]*[0-9a-z])?$~'), 'Invalid slug.');
			$this->slug = $slug;
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->slug;
		}


		/**
		 * @param  string $s
		 * @return self
		 */
		public static function fromString($s)
		{
			return new self(Strings::webalize($s));
		}


		/**
		 * @param  string $slug
		 * @return self
		 */
		public static function readUrlSlug($slug)
		{
			return new self($slug);
		}


		/**
		 * @return string
		 */
		public static function writeUrlSlug(self $slug)
		{
			return $slug->toString();
		}
	}
