<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class PhpParameterType implements IPhpParameterType
	{
		/** @var string */
		private $type;

		/** @var string[] */
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
		 * @param  string $type
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
		 * @return self
		 */
		public static function arrayType()
		{
			return self::getInstance('array');
		}


		/**
		 * @return self
		 */
		public static function boolType()
		{
			return self::getInstance('bool');
		}


		/**
		 * @return self
		 */
		public static function intType()
		{
			return self::getInstance('int');
		}


		/**
		 * @return self
		 */
		public static function floatType()
		{
			return self::getInstance('float');
		}


		/**
		 * @return self
		 */
		public static function stringType()
		{
			return self::getInstance('string');
		}


		/**
		 * @return self
		 */
		public static function callableType()
		{
			return self::getInstance('callable');
		}


		/**
		 * @return self
		 */
		public static function iterableType()
		{
			return self::getInstance('iterable');
		}


		/**
		 * @return self
		 */
		public static function selfType()
		{
			return self::getInstance('self');
		}


		/**
		 * @return self
		 */
		public static function objectType()
		{
			return self::getInstance('object');
		}


		/**
		 * @param  string $type
		 * @return self
		 */
		public static function classType($type)
		{
			$type = self::getInstance($type);
			Assert::true(!$type->isBasicType(), 'Class type cannot be basic type.');
			return $type;
		}


		/**
		 * @return self
		 */
		public static function fromPhpType(PhpType $type)
		{
			return self::getInstance($type->getType());
		}


		/**
		 * @param  string $type
		 * @return self
		 */
		private static function getInstance($type)
		{
			if (!isset(self::$instances[$type])) {
				self::$instances[$type] = new self($type);
			}

			return self::$instances[$type];
		}
	}
