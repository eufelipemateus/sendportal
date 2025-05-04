<?php

namespace App\Interfaces;

use App\Services\Messages\MessageTrackingOptions;

interface MailAdapterInterface
{
    /**
     * Send an email.
     *
     * @param string $fromEmail
     * @param string $fromName
     * @param string $toEmail
     * @param string $subject
     * @param MessageTrackingOptions $trackingOptions
     * @param string $content
     *
     * @return string
     */
    public function send(string $fromEmail, string $fromName, string $toEmail, string $subject, MessageTrackingOptions $trackingOptions, string $content): string;
}
