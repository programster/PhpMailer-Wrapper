<?php

namespace Programster\Phpmailer;

Interface EmailerInterface
{
    /**
     * Send an email.
     * @param string $toName - the name of the person to send email to
     * @param string $toEmail - email address of where to send the email to.
     * @param string $subject - subject of the email
     * @param string $message - the body of the email.
     * @param bool $htmlFormat - whether the email is in HTML format or not (defaults to true)
     * @return void
     * @throws ExceptionFailedToSendEmail - if failed to send the email for whatever reason.
     * @throws \PHPMailer\PHPMailer\Exception
     */
    public function send(
        string $subject,
        string $plaintextMessage,
        ?string $htmlMessage,
        ?ContactCollection $to,
        ?ContactCollection $cc = null,
        ?ContactCollection $bcc = null,
        ?AttachmentCollection $attachments = null,
    ) : void;
}

