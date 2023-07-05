<?php

	declare(strict_types=1);

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


		public function __construct(string $type)
		{
			Assert::string($type);
			$type = ltrim($type, '\\');
			Assert::true($type !== '', 'Type cannot be empty.');
			$this->type = $type;
		}


		public function isBasicType(): bool
		{
			return in_array($this->type, self::$basicTypes, TRUE);
		}


		public function getType(): string
		{
			return $this->type;
		}


		public function __toString(): string
		{
			return $this->type;
		}


		public static function arrayType(): self
		{
			return self::getInstance('array');
		}


		public static function boolType(): self
		{
			return self::getInstance('bool');
		}


		public static function intType(): self
		{
			return self::getInstance('int');
		}


		public static function floatType(): self
		{
			return self::getInstance('float');
		}


		public static function stringType(): self
		{
			return self::getInstance('string');
		}


		public static function callableType(): self
		{
			return self::getInstance('callable');
		}


		public static function iterableType(): self
		{
			return self::getInstance('iterable');
		}


		public static function selfType(): self
		{
			return self::getInstance('self');
		}


		public static function objectType(): self
		{
			return self::getInstance('object');
		}


		public static function classType(string $type): self
		{
			$type = self::getInstance($type);
			Assert::true(!$type->isBasicType(), 'Class type cannot be basic type.');
			return $type;
		}


		public static function fromPhpType(PhpType $type): self
		{
			return self::getInstance($type->getType());
		}


		private static function getInstance(string $type): self
		{
			if (!isset(self::$instances[$type])) {
				self::$instances[$type] = new self($type);
			}

			return self::$instances[$type];
		}
	}
