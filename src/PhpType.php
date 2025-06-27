<?php

	declare(strict_types=1);

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


		public function __construct(string $type)
		{
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


		public static function classType(string $type): self
		{
			$type = self::getInstance($type);
			Assert::true(!$type->isBasicType(), 'Class type cannot be basic type.');
			return $type;
		}


		public static function fromParameterType(PhpParameterType $parameterType): self
		{
			$type = $parameterType->getType();

			if ($type === 'self' || $type === 'object' || $type === 'callable' || $type === 'iterable') {
				throw new \Inteve\Types\InvalidArgumentException("Parameter type '$type' cannot be converted to " . PhpType::class . '.');
			}

			return self::getInstance($type);
		}


		private static function getInstance(string $type): self
		{
			if (!isset(self::$instances[$type])) {
				self::$instances[$type] = new self($type);
			}

			return self::$instances[$type];
		}
	}
