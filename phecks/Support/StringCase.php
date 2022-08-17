<?php

namespace Phecks\Support;

use Illuminate\Support\Stringable;

class StringCase
{
    private Stringable $value;

    public function __construct(string $value)
    {
        $this->value = new Stringable($value);
    }

    public static function of(string $string): self
    {
        return new self($string);
    }

    public function isCamelCase(): bool
    {
        return $this->value->camel()->value() === $this->value->value();
    }

    public function isKebabCase(): bool
    {
        return $this->value->camel()->kebab()->value() === $this->value->value();
    }
}
