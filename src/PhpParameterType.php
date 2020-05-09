<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class PhpParameterType
	{
		/** @var string */
		private $type;

		private static $basicTypes = [
			'array',
			'bool',
			'int',
			'float',
			'string',
			'callable',
			'iterable',
			'self',
			'object',
		];

		/** @var array<string, PhpParameterType> */
		private static $instances = [];


		/**
		 * @param  string
		 */
		public function __construct($type)
		{
			Assert::string($type);
			$type = ltrim($type, '\\');
			Assert::true($type !== '', 'Type cannot be empty.');
			$this->type = $type;
		}


		/**
		 * @return bool
		 */
		public function isBasicType()
		{
			return in_array($this->type, self::$basicTypes, TRUE);
		}


		/**
		 * @return string
		 */
		public function getType()
		{
			return $this->type;
		}


		public function __toString()
		{
			return $this->type;
		}


		/**
		 * @return static
		 */
		public static function arrayType()
		{
			return self::getInstance('array');
		}


		/**
		 * @return static
		 */
		public static function boolType()
		{
			return self::getInstance('bool');
		}


		/**
		 * @return static
		 */
		public static function intType()
		{
			return self::getInstance('int');
		}


		/**
		 * @return static
		 */
		public static function floatType()
		{
			return self::getInstance('float');
		}


		/**
		 * @return static
		 */
		public static function stringType()
		{
			return self::getInstance('string');
		}


		/**
		 * @return static
		 */
		public static function callableType()
		{
			return self::getInstance('callable');
		}


		/**
		 * @return static
		 */
		public static function iterableType()
		{
			return self::getInstance('iterable');
		}


		/**
		 * @return static
		 */
		public static function selfType()
		{
			return self::getInstance('self');
		}


		/**
		 * @return static
		 */
		public static function objectType()
		{
			return self::getInstance('object');
		}


		/**
		 * @return static
		 */
		public static function classType($type)
		{
			$type = self::getInstance($type);
			Assert::true(!$type->isBasicType(), 'Class type cannot be basic type.');
			return $type;
		}


		/**
		 * @return static
		 */
		private static function getInstance($type)
		{
			if (!isset(self::$instances[$type])) {
				self::$instances[$type] = new self($type);
			}

			return self::$instances[$type];
		}
	}
