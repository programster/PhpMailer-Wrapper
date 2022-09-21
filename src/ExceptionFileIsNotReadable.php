<?php

/*
 * A custom exception to raise if email sending fails.
 * Using a custom exception, allows the developer to gracefully handle different erroneous situations at a higher level.
 */

namespace Programster\Phpmailer;

class ExceptionFileIsNotReadable extends \Exception
{
    public function __construct(public readonly string $filepath)
    {
        parent::__construct("Cannot read file: {$filepath}");
    }
}


