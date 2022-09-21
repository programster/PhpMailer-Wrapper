<?php

namespace Programster\Phpmailer;

class Contact
{
    public function __construct(public readonly string $email, public readonly ?string $name)
    {

    }
}