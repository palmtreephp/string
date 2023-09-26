<?php

declare(strict_types=1);

namespace Palmtree\String\Test;

use function Palmtree\String\s;

use PHPUnit\Framework\TestCase;

class StrTest extends TestCase
{
    public function testLower(): void
    {
        $this->assertSame('foo', s('FOO')->lower()->toString());
    }

    public function testUpper(): void
    {
        $this->assertSame('FOO', s('foo')->upper()->toString());
    }

    public function testStartsWith(): void
    {
        $this->assertTrue(s('foo')->startsWith('f'));
        $this->assertFalse(s('foo')->startsWith('o'));
    }

    public function testEndsWith(): void
    {
        $this->assertTrue(s('foo')->endsWith('o'));
        $this->assertFalse(s('foo')->endsWith('f'));
    }

    public function testContains(): void
    {
        $this->assertTrue(s('foo')->contains('o'));
        $this->assertFalse(s('foo')->contains('bar'));
    }

    public function testReplace(): void
    {
        $this->assertSame('bar', s('foo')->replace('foo', 'bar')->toString());
        $this->assertSame('bar', s('foo')->replace(['foo'], ['bar'])->toString());
    }

    public function testReplaceMatches(): void
    {
        $this->assertSame('bar', s('foo')->replaceMatches('/foo/', 'bar')->toString());
        $this->assertSame('bar', s('foo')->replaceMatches(['/foo/'], ['bar'])->toString());
    }

    public function testReplaceMatchesCallback(): void
    {
        $this->assertSame('bar', s('foo')->replaceMatches('/foo/', fn () => 'bar')->toString());
        $this->assertSame('bar', s('foo')->replaceMatches(['/foo/'], fn () => 'bar')->toString());
    }

    public function testBefore(): void
    {
        $this->assertSame('hello ', s('hello world')->before('world')->toString());
        $this->assertSame('hello', s('hello')->before('world')->toString());
    }

    public function testAfter(): void
    {
        $this->assertSame(' world', s('hello world')->after('o')->toString());
        $this->assertSame('world', s('world')->after('hello')->toString());
    }

    public function testAfterLast(): void
    {
        $this->assertSame('rld', s('hello world')->afterLast('o')->toString());
        $this->assertSame('world', s('world')->afterLast('hello')->toString());
    }

    public function testBeforeLast(): void
    {
        $this->assertSame('hello w', s('hello world')->beforeLast('o')->toString());
        $this->assertSame('hello', s('hello')->beforeLast('world')->toString());
    }

    public function testSnakeCase(): void
    {
        $this->assertSame('foo_bar', s('foo-bar')->snake()->toString());
        $this->assertSame('foo_bar', s('Foo Bar')->snake()->toString());
        $this->assertSame('foo_bar', s('fooBar')->snake()->toString());
        $this->assertSame('foo_bar', s('foo bar')->snake()->toString());
        $this->assertSame('foo_bar', s('FooBar')->snake()->toString());
    }

    public function testKebabCase(): void
    {
        $this->assertSame('foo-bar', s('foo_bar')->kebab()->toString());
        $this->assertSame('foo-bar', s('Foo Bar')->kebab()->toString());
        $this->assertSame('foo-bar', s('fooBar')->kebab()->toString());
        $this->assertSame('foo-bar', s('foo bar')->kebab()->toString());
        $this->assertSame('foo-bar', s('FooBar')->kebab()->toString());
    }

    public function testCamelCase(): void
    {
        $this->assertSame('fooBar', s('foo_bar')->camel()->toString());
        $this->assertSame('fooBar', s('Foo Bar')->camel()->toString());
        $this->assertSame('fooBar', s('foo-bar')->camel()->toString());
        $this->assertSame('fooBar', s('foo bar')->camel()->toString());
        $this->assertSame('fooBar', s('FooBar')->camel()->toString());
    }

    public function testPascalCase(): void
    {
        $this->assertSame('FooBar', s('foo_bar')->pascal()->toString());
        $this->assertSame('FooBar', s('Foo Bar')->pascal()->toString());
        $this->assertSame('FooBar', s('foo-bar')->pascal()->toString());
        $this->assertSame('FooBar', s('foo bar')->pascal()->toString());
        $this->assertSame('FooBar', s('fooBar')->pascal()->toString());
    }

    public function testTitleCase(): void
    {
        $this->assertSame('Foo Bar', s('foo_bar')->title()->toString(), 'Snake case to title case');
        $this->assertSame('Foo Bar', s('FooBar')->title()->toString(), 'Pascal case to title case');
        $this->assertSame('Foo Bar', s('foo-bar')->title()->toString(), 'Kebab case to title case');
        $this->assertSame('Foo Bar', s('foo bar')->title()->toString(), 'Lower case to title case');
        $this->assertSame('Foo Bar', s('fooBar')->title()->toString(), 'Camel case to title case');
    }

    public function testUpperFirst(): void
    {
        $this->assertSame('Foo', s('foo')->upperFirst()->toString());
        $this->assertSame('Foo', s('Foo')->upperFirst()->toString());
    }

    public function testLowerFirst(): void
    {
        $this->assertSame('foo', s('Foo')->lowerFirst()->toString());
        $this->assertSame('foo', s('foo')->lowerFirst()->toString());
    }

    public function testTrim(): void
    {
        $this->assertSame('foo', s(' foo ')->trim()->toString());
        $this->assertSame('foo', s('foo ')->trim()->toString());
        $this->assertSame('foo', s(' foo')->trim()->toString());
        $this->assertSame('foo', s('foo')->trim()->toString());
    }

    public function testTrimLeft(): void
    {
        $this->assertSame('foo ', s(' foo ')->trimLeft()->toString());
        $this->assertSame('foo ', s('foo ')->trimLeft()->toString());
        $this->assertSame('foo', s(' foo')->trimLeft()->toString());
        $this->assertSame('foo', s('foo')->trimLeft()->toString());
    }

    public function testTrimRight(): void
    {
        $this->assertSame(' foo', s(' foo ')->trimRight()->toString());
        $this->assertSame('foo', s('foo ')->trimRight()->toString());
        $this->assertSame(' foo', s(' foo')->trimRight()->toString());
        $this->assertSame('foo', s('foo')->trimRight()->toString());
    }

    public function testReverse(): void
    {
        $this->assertSame('oof', s('foo')->reverse()->toString());
    }

    public function testLength(): void
    {
        $this->assertSame(3, s('foo')->length());
    }

    public function testSplit(): void
    {
        $this->assertSame(['foo', 'bar'], s('foo,bar')->split(','));
        $this->assertSame(['foo', 'bar,baz'], s('foo,bar,baz')->split(',', 2));
    }

    public function testAppend(): void
    {
        $this->assertSame('foobar', s('foo')->append('bar')->toString());
    }

    public function testPrepend(): void
    {
        $this->assertSame('foobar', s('bar')->prepend('foo')->toString());
    }

    public function testTrimPrefix(): void
    {
        $this->assertSame('bar', s('foobar')->trimPrefix('foo')->toString());
        $this->assertSame('bar', s('bar')->trimPrefix('foo')->toString());
    }

    public function testTrimSuffix(): void
    {
        $this->assertSame('foo', s('foobar')->trimSuffix('bar')->toString());
        $this->assertSame('foo', s('foo')->trimSuffix('bar')->toString());
    }

    public function testToString(): void
    {
        $this->assertSame('foo', s('foo')->toString());
    }

    public function testToStringMagic(): void
    {
        $this->assertSame('foo', (string)s('foo'));
    }

    public function testMatch(): void
    {
        $this->assertSame(['foo'], s('foo')->match('/foo/'));
    }

    public function testTest(): void
    {
        $this->assertTrue(s('foo')->test('/^foo$/'));
        $this->assertFalse(s('bar')->test('/foo/'));
    }
}
