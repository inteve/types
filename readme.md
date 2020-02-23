
# Inteve\Types

[![Build Status](https://travis-ci.org/inteve/types.svg?branch=master)](https://travis-ci.org/inteve/types)

Value objects and helpers for PHP.

<a href="https://www.paypal.me/janpecha/1eur"><img src="https://buymecoffee.intm.org/img/button-paypal-white.png" alt="Buy me a coffee" height="35"></a>


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
