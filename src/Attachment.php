<?php

namespace Programster\Phpmailer;

class Attachment
{
    public readonly string $name;


    /**
     * Create an attachment for an email
     * @param string $filepath - the path to the file to add as an attachment
     * @param ?string $name - optionally specify a name for the attachment. If set left as null, the name of the file
     * will be used.
     * @param AttachmentEncoding $encoding - the encoding of the attachment.
     * @param string|null $mimetype - the mimetype of the attached file. E.g. "application/pdf". If left as null,
     * this will try to be automatically determined.
     * @throws ExceptionFileDoesNotExist - if there is no file at $filepath
     * @throws ExceptionFileIsNotReadable - if the file at $filepath cannot be read to add as an attachment.
     */
    public function __construct(
        public readonly string $filepath,
        ?string $name = null,
        public readonly AttachmentEncoding $encoding = AttachmentEncoding::BASE_64,
        public readonly ?string $mimetype = null
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

        $this->name = $name ?? (string) pathinfo($filepath, PATHINFO_BASENAME);
    }
}