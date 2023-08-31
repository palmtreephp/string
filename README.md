# :palm_tree: Palmtree String

[![License](http://img.shields.io/packagist/l/palmtree/string.svg)](LICENSE)
[![Build](https://img.shields.io/github/actions/workflow/status/palmtreephp/string/build.yaml?branch=master)](https://github.com/palmtreephp/string/actions/workflows/build.yaml)
[![Packagist Version](https://img.shields.io/packagist/v/palmtree/string)](https://packagist.org/packages/palmtree/string)

Object-oriented string manipulation library

## Requirements

* PHP >= 8.1

## Installation

Use composer to add the package to your dependencies:

```bash
composer require palmtree/string
```

## Usage

```php
use function Palmtree\String\s;

$str = s('foo bar baz');

$str->startsWith('foo'); // true
$str->endsWith('baz'); // true
$str->contains('bar'); // true

$str->replace('bar', 'qux'); // 'foo qux baz'

$str->after('bar'); // ' baz'
$str->afterLast('b'); // 'az'
$str->beforeFirst('b'); // 'foo '

$str->kebab(); // 'foo-bar-baz'
$str->camel(); // 'fooBarBaz'
$str->snake(); // 'foo_bar_baz'

```

Many other methods are provided. Read through the documented [source code](src/Str.php) to see more.

## License

Released under the [MIT license](LICENSE)
