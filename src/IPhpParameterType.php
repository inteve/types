<?php

	declare(strict_types=1);

	namespace Inteve\Types;


	interface IPhpParameterType
	{
		function isBasicType(): bool;


		function getType(): string;


		function __toString(): string;
	}
