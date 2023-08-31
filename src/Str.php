<?php

declare(strict_types=1);

namespace Palmtree\String;

final class Str implements \Stringable
{
    public function __construct(private readonly string $string)
    {
    }

    /**
     * @return string|array<string>
     */
    public static function unwrap(string|\Stringable|array $value): string|array
    {
        if (\is_array($value)) {
            return array_map(fn ($value) => (string)$value, $value);
        }

        return (string)$value;
    }

    public function lower(): self
    {
        return new self(strtolower($this->string));
    }

    public function upper(): self
    {
        return new self(strtoupper($this->string));
    }

    public function upperFirst(): self
    {
        return new self(ucfirst($this->string));
    }

    public function lowerFirst(): self
    {
        return new self(lcfirst($this->string));
    }

    public function title(): self
    {
        return $this
            ->replace(['_', '-'], ' ')
            ->replaceMatches('/([a-z])([A-Z])/', '$1 $2')
            ->replaceMatches('/[^a-zA-Z0-9]+([a-zA-Z0-9])/', fn (array $matches) => ' ' . strtoupper($matches[1]))
            ->upperFirst();
    }

    public function camel(): self
    {
        return $this
            ->title()
            ->lowerFirst()
            ->replace('-', '_')
            ->replaceMatches('/[^a-zA-Z0-9]+([a-zA-Z0-9])/', fn (array $matches) => strtoupper($matches[1]));
    }

    public function snake(): self
    {
        return $this
            ->replace(['-', ' '], '_')
            ->replaceMatches('/([a-z])([A-Z])/', '$1_$2')
            ->lower();
    }

    public function kebab(): self
    {
        return $this
            ->replace(['_', ' '], '-')
            ->replaceMatches('/([a-z])([A-Z])/', '$1-$2')
            ->lower();
    }

    public function pascal(): self
    {
        return $this->camel()->upperFirst();
    }

    public function startsWith(string|\Stringable $string): bool
    {
        return str_starts_with($this->string, (string)$string);
    }

    public function endsWith(string|\Stringable $string): bool
    {
        return str_ends_with($this->string, (string)$string);
    }

    public function contains(string|\Stringable $string): bool
    {
        return str_contains($this->string, (string)$string);
    }

    public function replace(string|\Stringable|array $search, string|\Stringable|array $replace): self
    {
        return new self(str_replace(self::unwrap($search), self::unwrap($replace), $this->string));
    }

    /**
     * @param string|\Stringable|array|Closure(array<string>): string $replacement
     *
     * @psalm-suppress ArgumentTypeCoercion
     */
    public function replaceMatches(string|\Stringable|array $pattern, string|\Stringable|array|\Closure $replacement, int $limit = -1): self
    {
        if ($replacement instanceof \Closure) {
            /** @psalm-var Closure(array<string>): string $replacement */
            return new self(preg_replace_callback(self::unwrap($pattern), $replacement, $this->string, $limit));
        }

        return new self(preg_replace(self::unwrap($pattern), self::unwrap($replacement), $this->string, $limit));
    }

    /**
     * @param int-mask<0, 256, 512> $flags
     */
    public function match(string|\Stringable $pattern, int $flags = 0, int $offset = 0): array
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        preg_match((string)$pattern, $this->string, $matches, $flags, $offset);

        return $matches;
    }

    /**
     * @param int-mask<0, 256, 512> $flags
     */
    public function test(string|\Stringable $pattern, int $flags = 0, int $offset = 0): bool
    {
        /** @psalm-suppress ArgumentTypeCoercion */
        return preg_match((string)$pattern, $this->string, $matches, $flags, $offset) === 1;
    }

    public function before(string|\Stringable $string): self
    {
        $pos = strpos($this->string, (string)$string);

        if ($pos === false) {
            return new self($this->string);
        }

        return new self(substr($this->string, 0, $pos));
    }

    public function after(string|\Stringable $string): self
    {
        $pos = strpos($this->string, (string)$string);

        if ($pos === false) {
            return new self($this->string);
        }

        return new self(substr($this->string, $pos + \strlen((string)$string)));
    }

    public function beforeLast(string|\Stringable $string): self
    {
        $pos = strrpos($this->string, (string)$string);

        if ($pos === false) {
            return new self($this->string);
        }

        return new self(substr($this->string, 0, $pos));
    }

    public function afterLast(string|\Stringable $string): self
    {
        $pos = strrpos($this->string, (string)$string);

        if ($pos === false) {
            return new self($this->string);
        }

        return new self(substr($this->string, $pos + \strlen((string)$string)));
    }

    public function trim(string|\Stringable $characters = " \t\n\r\0\x0B"): self
    {
        return new self(trim($this->string, (string)$characters));
    }

    public function trimLeft(string|\Stringable $characters = " \t\n\r\0\x0B"): self
    {
        return new self(ltrim($this->string, (string)$characters));
    }

    public function trimRight(string|\Stringable $characters = " \t\n\r\0\x0B"): self
    {
        return new self(rtrim($this->string, (string)$characters));
    }

    public function trimPrefix(string|\Stringable $prefix): self
    {
        return $this->startsWith($prefix) ? $this->afterLast($prefix) : new self($this->string);
    }

    public function trimSuffix(string|\Stringable $suffix): self
    {
        return $this->endsWith($suffix) ? $this->beforeLast($suffix) : new self($this->string);
    }

    public function append(string|\Stringable $suffix): self
    {
        return new self($this->string . $suffix);
    }

    public function prepend(string|\Stringable $prefix): self
    {
        return new self($prefix . $this->string);
    }

    public function reverse(): self
    {
        return new self(strrev($this->string));
    }

    public function length(): int
    {
        return \strlen($this->string);
    }

    public function __toString(): string
    {
        return $this->string;
    }

    public function toString(): string
    {
        return $this->string;
    }
}
