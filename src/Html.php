<?php

	declare(strict_types=1);

	namespace Inteve\Types;


	class Html implements \Nette\Utils\IHtmlString
	{
		/** @var string */
		private $html;


		public function __construct(string $html)
		{
			$this->html = $html;
		}


		public function getHtml(): string
		{
			return $this->html;
		}


		public function getPlainText(): string
		{
			return html_entity_decode(strip_tags($this->html), ENT_QUOTES, 'UTF-8');
		}


		public function __toString(): string
		{
			return $this->html;
		}


		public static function fromText(string $s): self
		{
			return new self(nl2br(htmlspecialchars($s, ENT_NOQUOTES | ENT_SUBSTITUTE, 'UTF-8'), FALSE));
		}
	}
