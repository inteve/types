
# Inteve\Types

Value objects and helpers for PHP.


## Installation

[Download a latest package](https://github.com/inteve/types/releases) or use [Composer](http://getcomposer.org/):

```
composer require inteve/types
```

Inteve\Types requires PHP 5.6.0 or later.


## Usage

* [Md5](#md5)


### Md5

```php
use Inteve\Types\Md5;

$md5 = new Md5($hash);
$md5->getHash(); // returns $hash

// from string
$md5 = Md5::from('Lorem ipsum dolor.');

// from file
$md5 = Md5::fromFile('/path/to/file');
```

------------------------------

License: [New BSD License](license.md)
<br>Author: Jan Pecha, https://www.janpecha.cz/
