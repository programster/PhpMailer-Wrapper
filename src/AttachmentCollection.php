<?php

namespace Programster\Phpmailer;


final class AttachmentCollection extends \ArrayObject
{
    public function __construct(Attachment ...$attachments)
    {
        parent::__construct($attachments);
    }


    public function append(mixed $value) : void
    {
        if ($value instanceof Attachment)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non Attachment to a " . __CLASS__);
        }
    }


    public function offsetSet(mixed $key, mixed $value) : void
    {
        if ($value instanceof Attachment)
        {
            parent::offsetSet($key, $value);
        }
        else
        {
            throw new Exception("Cannot add a non Attachment value to a " . __CLASS__);
        }
    }
}