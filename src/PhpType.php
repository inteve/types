<?php

	namespace Inteve\Types;

	use CzProject\Assert\Assert;
	use Nette\Utils\Validators;


	class PhpType implements IPhpParameterType
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
		];

		/** @var array<string, PhpType> */
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
		public static function fromParameterType(PhpParameterType $parameterType)
		{
			$type = $parameterType->getType();

			if ($type === 'self' || $type === 'object' || $type === 'callable' || $type === 'iterable') {
				throw new \Inteve\Types\InvalidArgumentException("Parameter type '$type' cannot be converted to " . PhpType::class . '.');
			}

			return self::getInstance($type);
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
