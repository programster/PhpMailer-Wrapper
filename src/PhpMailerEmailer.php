<?php

/* 
 * This class wraps around PHPMailer to send an email using SMTP. You could just use PHPMailer 
 * directly, but if you go with this, you stick to an interface that allows you to swap emailer
 * super easily in future.
 */

namespace Programster\Phpmailer;

use PHPMailer\PHPMailer\PHPMailer;


class PhpMailerEmailer implements EmailerInterface
{
    private readonly Contact $replyToContact;
    
    
    /**
     * Create an emailer object that wraps around PhpMailer to send an email through SMTP.
     *
     * @param string $smtpHost - the host of the SMTP provider.
     *
     * @param string $smtpUser - username or email address for authenticating with SMTP provider.
     *
     * @param string $smtpPassword - password for authenticating with SMTP provider.
     *
     * @param SecurityProtocol $securityProtocol - should be 'tls' or 'ssl' for how you send emails
     *
     * @param string $fromEmail - who the email should appear as if its from.
     *
     * @param string $fromName - the name that should appears as the email is from.
     *
     * @param int $smtpPort - the port to connect to the SMTP provider with (defaults to 587)
     *
     * @param ?string $replyToEmail - optionally specify where the user should reply to with. If not
     * provided then this will default to $fromEmail
     *
     * @param ?Contact $replyTo - the name and email of the reply to address. Leave as null for this to default to
     * the from address.
     */
    public function __construct(
        private readonly string $smtpHost,
        private readonly string $smtpUser,
        private readonly string $smtpPassword,
        private readonly SecurityProtocol $securityProtocol,
        private readonly Contact $from,
        private readonly int $smtpPort = 587,
        private ?Contact $replyTo = null,
    )
    {
        if ($this->replyTo === null)
        {
            $this->replyTo = $from;
        }
    }
    

    public function send(
        string $subject,
        string $plaintextMessage,
        ?string $htmlMessage,
        ?ContactCollection $to,
        ?ContactCollection $cc = null,
        ?ContactCollection $bcc = null,
        AttachmentCollection $attachments = null
    ) : void
    {
        $mailer = new PHPMailer();
        $mailer->isSMTP();
        $mailer->Host = $this->smtpHost;
        $mailer->SMTPAuth = true;
        $mailer->Username = $this->smtpUser;
        $mailer->Password = $this->smtpPassword;
        $mailer->SMTPSecure = $this->securityProtocol->value;
        $mailer->Port = $this->smtpPort;
        $mailer->setFrom($this->from->email, $this->from->name ?? '');
        $mailer->addReplyTo($this->replyTo->email, $this->replyTo->name ?? '');
        $mailer->Subject = $subject;

        if ($htmlMessage !== null)
        {
            $mailer->Body    = $htmlMessage;
            $mailer->AltBody = strip_tags($plaintextMessage);
            $mailer->isHTML(true);
        }
        else
        {
            $mailer->Body = $plaintextMessage;
            $mailer->isHTML(false);
        }

        $hasRecipients = false;

        if ($to !== null)
        {
            $hasRecipients = true;

            foreach ($to as $toContact)
            {
                /* @var $toContact Contact */
                $mailer->addAddress($toContact->email, $toContact->name ?? "");
            }
        }

        if ($cc !== null)
        {
            $hasRecipients = true;

            foreach ($cc as $ccContact)
            {
                /* @var $ccContact Contact */
                $mailer->addCC($ccContact->email, $ccContact->name ?? "");
            }
        }

        if ($bcc !== null)
        {
            $hasRecipients = true;

            foreach ($bcc as $bccContact)
            {
                /* @var $bccContact Contact */
                $mailer->addBCC($bccContact->email, $bccContact->name ?? "");
            }
        }


        if ($attachments !== null && count($attachments) > 0)
        {
            foreach ($attachments as $attachment)
            {
                /* @var $attachment Attachment */
                $mailer->addAttachment(
                    $attachment->filepath,
                    $attachment->name,
                    $attachment->encoding->value,
                    $attachment->mimetype ?? ''
                );
            }
        }

        if ($hasRecipients === FALSE)
        {
            throw new ExceptionFailedToSendEmail("Cannot send email when there are no configured recipients.");
        }
        
        if ($mailer->send() === false)
        {
            throw new ExceptionFailedToSendEmail("Failed to send email: " . $mailer->ErrorInfo);
        } 
    }
}

