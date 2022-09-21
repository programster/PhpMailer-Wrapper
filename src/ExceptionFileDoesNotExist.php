<?php

/*
 * A custom exception to raise if email sending fails.
 * Using a custom exception, allows the developer to gracefully handle different erroneous situations at a higher level.
 */

namespace Programster\Phpmailer;

class ExceptionFileDoesNotExist extends \Exception
{
    public function __construct(public readonly string $filepath)
    {
        parent::__construct("File does not exist: {$filepath}");
    }
}


