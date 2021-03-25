<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Strings;


	class UrlPath
	{
		/** @var string */
		private $path;


		/**
		 * @param  string $path
		 */
		public function __construct($path)
		{
			Assert::string($path);
			Assert::true($path === '/' || ((bool) Strings::match($path, '~^[0-9a-z]([0-9a-z-]*[0-9a-z])?(\/[0-9a-z]([0-9a-z-]*[0-9a-z])?)*$~')), 'Invalid path.');
			$this->path = $path;
		}


		/**
		 * @return bool
		 */
		public function isRoot()
		{
			return $this->path === '/';
		}


		/**
		 * @return int
		 */
		public function getLevel()
		{
			if ($this->path === '/') {
				return 0;
			}

			return substr_count($this->path, '/') + 1;
		}


		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->path;
		}


		/**
		 * @return string
		 */
		public function getBaseName()
		{
			if ($this->path === '/') {
				return $this->path;
			}

			$pos = strrpos($this->path, '/');

			if ($pos === FALSE) {
				return $this->path;
			}

			return substr($this->path, $pos + 1);
		}


		/**
		 * @return string|NULL
		 */
		public function getDirectoryName()
		{
			if ($this->path === '/') {
				return NULL;
			}

			$pos = strrpos($this->path, '/');

			if ($pos === FALSE) {
				return NULL;
			}

			return substr($this->path, 0, $pos);
		}


		/**
		 * @param  string $s
		 * @return self
		 */
		public static function fromString($s)
		{
			$s = Strings::webalize($s, '/');

			if ($s !== '/') {
				$s = Strings::trim($s, '/');
			}

			return new self($s);
		}


		/**
		 * @param  string $path
		 * @return self
		 */
		public static function readUrlPath($path)
		{
			return new self($path);
		}


		/**
		 * @return string
		 */
		public static function writeUrlPath(self $path)
		{
			return $path->toString();
		}
	}
