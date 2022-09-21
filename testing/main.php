<?php

use Programster\Phpmailer\Attachment;
use Programster\Phpmailer\AttachmentCollection;
use Programster\Phpmailer\PhpMailerEmailer;
use Programster\Phpmailer\SecurityProtocol;

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/Settings.php');

# Test that phpmailer works 
# (you will need to log into your email account and check that you actually get the email)
$mailer = new PhpMailerEmailer(
    SMTP_HOST, 
    SMTP_USER, 
    SMTP_PASSWORD, 
    SecurityProtocol::tryFrom(SMTP_TLS_OR_SSL),
    SMTP_FROM,
    $smtpPort = 587
);



$mailer->send(
    'emailer test - plaintext',
    "This is a plaintext email on its own",
    null,
    to: EMAIL_TO,
    cc: EMAIL_CC,
    bcc: EMAIL_BCC,
);

// now send a more complicated HTML email with attachments.

$attachments = new AttachmentCollection(
    new Attachment(__DIR__ . '/sample.pdf', "example-pdf.pdf"),
    new Attachment(__DIR__ . '/sample.pdf', "second-pdf.pdf"),
);

$mailer->send(
    subject: 'Send Email Test - html with altbody and attachment',
    plaintextMessage: "This is the alt body",
    htmlMessage: "<h1>HTML Email</h1><p>This is an html email with an attachment</p>",
    to: EMAIL_TO,
    cc: EMAIL_CC,
    bcc: EMAIL_BCC,
    attachments: $attachments
);