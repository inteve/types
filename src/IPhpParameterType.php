<?php

	namespace Inteve\Types;


	interface IPhpParameterType
	{
		/**
		 * @return bool
		 */
		function isBasicType();


		/**
		 * @return string
		 */
		function getType();


		function __toString();
	}
