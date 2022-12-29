<?php

namespace Programster\Phpmailer;


class EmbeddedImage
{
    public readonly string $cid;


    /**
     * Create an attachment for an email
     * @param string $filepath - the path to the file to add as an attachment
     * @param ?string $cid - optionally specify a the cid for the attachment. This is how the file is referenced to
     * within the content of the body of the email If set left as null, the name of the file.
     * @throws ExceptionFileDoesNotExist - if there is no file at $filepath
     * @throws ExceptionFileIsNotReadable - if the file at $filepath cannot be read to add as an attachment.
     */
    public function __construct(
        public readonly string $filepath,
        string $cid = null
    )
    {
        if (file_exists($filepath) === false)
        {
            throw new ExceptionFileDoesNotExist($filepath);
        }

        if (is_readable($filepath) === false)
        {
            throw new ExceptionFileIsNotReadable($filepath);
        }

        $this->cid = $cid ?? (string) pathinfo($filepath, PATHINFO_BASENAME);
    }
}