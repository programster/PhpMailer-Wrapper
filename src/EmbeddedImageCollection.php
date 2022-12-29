<?php

namespace Programster\Phpmailer;


final class EmbeddedImageCollection extends \ArrayObject
{
    public function __construct(EmbeddedImage ...$images)
    {
        parent::__construct($images);
    }


    public function append(mixed $value) : void
    {
        if ($value instanceof EmbeddedImage)
        {
            parent::append($value);
        }
        else
        {
            throw new Exception("Cannot append non EmbeddedImage to a " . __CLASS__);
        }
    }


    public function offsetSet(mixed $key, mixed $value) : void
    {
        if ($value instanceof EmbeddedImage)
        {
            parent::offsetSet($key, $value);
        }
        else
        {
            throw new Exception("Cannot add a non EmbeddedImage value to a " . __CLASS__);
        }
    }
}