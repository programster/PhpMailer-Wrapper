<?php

namespace Programster\Emailers;

class Contact
{
    public function __construct(public readonly string $email, public readonly ?string $name)
    {

    }
}