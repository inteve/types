
# Inteve\Types

[![Build Status](https://travis-ci.org/inteve/types.svg?branch=master)](https://travis-ci.org/inteve/types)

Value objects and helpers for PHP.

---

**Do you like this project? Please consider its support. Thank you!**

<a href="https://www.paypal.me/janpecha/5eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>

---


## Installation

[Download a latest package](https://github.com/inteve/types/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/types
```

Inteve\Types requires PHP 5.6.0 or later.


## Usage

* [HexColor](#hexcolor)
* [Html](#html)
* [Md5Hash](#md5hash)
* [PhpType](#phptype)
* [Url](#url)


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
```


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
