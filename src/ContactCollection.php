<?php

namespace Programster\Phpmailer;


final class ContactCollection extends \ArrayObject
{
    public function __construct(Contact ...$contacts)
    {
        parent::__construct($contacts);
    }


    public function append(mixed $value) : void
    {
        if ($value instanceof Contact)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Contact to a " . __CLASS__);
        }
    }


    public function offsetSet(mixed $key, mixed $value) : void
    {
        if ($value instanceof Contact)
        {
            parent::offsetSet($key, $value);
        }
        else
        {
            throw new Exception("Cannot add a non Contact value to a " . __CLASS__);
        }
    }
}