<?php
namespace vendor\string\traits;

trait Symbols
{
    private $spec_symbols = ['OR', 'NOT', 'or', 'not', 'and', 'AND'];
    private $math_symbols = ['>=', '<=', '>', '<', '<>', '='];

    protected function check_math_symbols($symbols): bool
    {
        return in_array($symbols, $this->math_symbols);
    }
    protected function check_spec_symbols($symbols): bool
    {
        return in_array($symbols, $this->spec_symbols);
    }
}