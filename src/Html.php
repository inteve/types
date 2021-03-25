<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;


	class Html implements \Nette\Utils\IHtmlString
	{
		/** @var string */
		private $html;


		/**
		 * @param  string $html
		 */
		public function __construct($html)
		{
			Assert::string($html);
			$this->html = $html;
		}


		/**
		 * @return string
		 */
		public function getHtml()
		{
			return $this->html;
		}


		/**
		 * @return string
		 */
		public function getPlainText()
		{
			return html_entity_decode(strip_tags($this->html), ENT_QUOTES, 'UTF-8');
		}


		public function __toString()
		{
			return $this->html;
		}
	}
