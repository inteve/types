<?php

	namespace Inteve\Types;


	class TypeSerializer
	{
		public function __construct()
		{
			throw new StaticClassException('This is static class.');
		}


		/**
		 * @param  string $html
		 * @return Html
		 */
		public static function readHtml($html)
		{
			return new Html($html);
		}


		/**
		 * @return string
		 */
		public static function writeHtml(Html $html)
		{
			return $html->getHtml();
		}


		/**
		 * @param  string $ipAddress
		 * @return IpAddress
		 */
		public static function readIpAddress($ipAddress)
		{
			return new IpAddress($ipAddress);
		}


		/**
		 * @return string
		 */
		public static function writeIpAddress(IpAddress $ipAddress)
		{
			return $ipAddress->toString();
		}


		/**
		 * @param  string $hash
		 * @return Md5Hash
		 */
		public static function readMd5Hash($hash)
		{
			return new Md5Hash($hash);
		}


		/**
		 * @return string
		 */
		public static function writeMd5Hash(Md5Hash $hash)
		{
			return $hash->getHash();
		}


		/**
		 * @param  string $hash
		 * @return Password
		 */
		public static function readPassword($hash)
		{
			return new Password($hash);
		}


		/**
		 * @return string
		 */
		public static function writePassword(Password $password)
		{
			return $password->getHash();
		}


		/**
		 * @param  string $url
		 * @return Url
		 */
		public static function readUrl($url)
		{
			return new Url($url);
		}


		/**
		 * @return string
		 */
		public static function writeUrl(Url $url)
		{
			return $url->getUrl();
		}


		/**
		 * @param  string $path
		 * @return UrlPath
		 */
		public static function readUrlPath($path)
		{
			return new UrlPath($path);
		}


		/**
		 * @return string
		 */
		public static function writeUrlPath(UrlPath $path)
		{
			return $path->toString();
		}


		/**
		 * @param  string $slug
		 * @return UrlSlug
		 */
		public static function readUrlSlug($slug)
		{
			return new UrlSlug($slug);
		}


		/**
		 * @return string
		 */
		public static function writeUrlSlug(UrlSlug $slug)
		{
			return $slug->toString();
		}


		/**
		 * @param  string $id
		 * @return UniqueId
		 */
		public static function readUniqueId($id)
		{
			return new UniqueId($id);
		}


		/**
		 * @return string $id
		 */
		public static function writeUniqueId(UniqueId $id)
		{
			return $id->toString();
		}
	}
