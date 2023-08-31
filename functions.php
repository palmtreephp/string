<?php

namespace Palmtree\String;

function s(string $string): Str
{
    return new Str($string);
}
