# Inteve\Types

[![Build Status](https://github.com/inteve/types/workflows/Build/badge.svg)](https://github.com/inteve/types/actions)
[![Downloads this Month](https://img.shields.io/packagist/dm/inteve/types.svg)](https://packagist.org/packages/inteve/types)
[![Latest Stable Version](https://poser.pugx.org/inteve/types/v/stable)](https://github.com/inteve/types/releases)
[![License](https://img.shields.io/badge/license-New%20BSD-blue.svg)](https://github.com/inteve/types/blob/master/license.md)

Value objects and helpers for PHP.

<a href="https://www.janpecha.cz/donate/"><img src="https://buymecoffee.intm.org/img/donate-banner.v1.svg" alt="Donate" height="100"></a>


## Installation

[Download a latest package](https://github.com/inteve/types/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/types
```

Inteve\Types requires PHP 5.6.0 or later.


## Usage

* BinaryData
* EmailAddress
* [DatabaseDataType](#databasedatatype)
* Decimal
* [HexColor](#hexcolor)
* [Html](#html)
* IpAddress
* [Md5Hash](#md5hash)
* Password
* [PhpType](#phptype)
* [PhpParameterType](#phpparametertype)
* UniqueId
* [Url](#url)
* UrlPath
* UrlSlug


### DatabaseDataType

```php
use Inteve\Types\DatabaseDataType;

$type = new DatabaseDataType('INT', [10], ['UNSIGNED']);
$type->getType();
$type->getParameters();
$type->getOptions();
$type->hasOption('UNSIGNED'); // returns TRUE
$type->getOptionValue('UNSINGED'); // returns mixed|NULL
```


### HexColor

```php
use Inteve\Types\HexColor;

$color = new HexColor('0088FF');
$color->getValue(); // returns '0088ff'
$color->getCssValue(); // returns '#0088ff'

// from CSS color
$color = HexColor::fromCssColor('#0088ff');
```

### Html

```php
use Inteve\Types\Html;

$html = new Html('<p>Lorem &gt; ipsum</p>');
$html->getHtml();
(string) $html; // alias for getHtml()

$html->getPlainText(); // returns text without HTML tags & entities ('Lorem > ipsum')
```

It implements `Nette\Utils\IHtmlString` so can be used directly in Latte template (`{$html}`) without `|noescape` modifier.


### Md5Hash

```php
use Inteve\Types\Md5Hash;

$md5 = new Md5Hash($hash);
$md5->getHash(); // returns $hash

// from string
$md5 = Md5Hash::from('Lorem ipsum dolor.');

// from file
$md5 = Md5Hash::fromFile('/path/to/file');
```


### PhpType

```php
use Inteve\Types\PhpType;

$type = new PhpType('bool');
$type->getType();
(string) $type; // alias for getType()
$type->isBasicType(); // returns TRUE

$type = new PhpType(PhpType::class);
$type->isBasicType(); // returns FALSE
```

You can use static factories:

```php
$type = PhpType::arrayType();
$type = PhpType::boolType();
$type = PhpType::floatType();
$type = PhpType::intType();
$type = PhpType::stringType();
$type = PhpType::classType(PhpType::class);

$type = PhpType::fromParameterType(new PhpParameterType('string'));
```

It implements `Inteve\Types\IPhpParameterType`.


### PhpParameterType

```php
use Inteve\Types\PhpParameterType;

$type = new PhpParameterType('bool');
$type->getType();
(string) $type; // alias for getType()
$type->isBasicType(); // returns TRUE

$type = new PhpParameterType(PhpParameterType::class);
$type->isBasicType(); // returns FALSE
```

You can use static factories:

```php
$type = PhpParameterType::arrayType();
$type = PhpParameterType::boolType();
$type = PhpParameterType::floatType();
$type = PhpParameterType::intType();
$type = PhpParameterType::stringType();
$type = PhpParameterType::callableType();
$type = PhpParameterType::iterableType();
$type = PhpParameterType::selfType();
$type = PhpParameterType::objectType();
$type = PhpParameterType::classType(PhpParameterType::class);

$type = PhpParameterType::fromPhpType(new PhpType('string'));
```

It implements `Inteve\Types\IPhpParameterType`.


### Url

```php
use Inteve\Types\Url;

$url = new Url('https://example.com/page');
$url->getUrl();
(string) $url; // alias for getUrl()
```


------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
