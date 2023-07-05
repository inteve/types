<?php

	declare(strict_types=1);

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class Url
	{
		/** @var string */
		private $url;


		/**
		 * @param  string $url
		 */
		public function __construct($url)
		{
			Assert::string($url);
			Assert::true(Validators::isUrl($url), 'Invalid URL.');
			$this->url = $url;
		}


		/**
		 * @return string
		 */
		public function getUrl()
		{
			return $this->url;
		}


		public function __toString()
		{
			return $this->url;
		}
	}
