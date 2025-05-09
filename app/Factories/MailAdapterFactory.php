<?php

declare(strict_types=1);

namespace App\Factories;

use InvalidArgumentException;
use App\Adapters\MailgunMailAdapter;
use App\Adapters\MailjetAdapter;
use App\Adapters\PostalAdapter;
use App\Adapters\PostmarkMailAdapter;
use App\Adapters\SendgridMailAdapter;
use App\Adapters\SesMailAdapter;
use App\Adapters\SmtpAdapter;
use App\Interfaces\MailAdapterInterface;
use App\Models\EmailService;
use App\Models\EmailServiceType;

class MailAdapterFactory
{
    /** @var array */
    public static $adapterMap = [
        EmailServiceType::SES => SesMailAdapter::class,
        EmailServiceType::SENDGRID => SendgridMailAdapter::class,
        EmailServiceType::MAILGUN => MailgunMailAdapter::class,
        EmailServiceType::POSTMARK => PostmarkMailAdapter::class,
        EmailServiceType::MAILJET => MailjetAdapter::class,
        EmailServiceType::SMTP => SmtpAdapter::class,
        EmailServiceType::POSTAL => PostalAdapter::class,
    ];

    /**
     * Cache of resolved mail adapters.
     *
     * @var array
     */
    private $adapters = [];

    /**
     * Get a mail adapter instance.
     */
    public function adapter(EmailService $emailService): MailAdapterInterface
    {
        return $this->adapters[$emailService->id] ?? $this->cache($this->resolve($emailService), $emailService);
    }

    /**
     * Cache a resolved adapter for the given provider.
     */
    private function cache(MailAdapterInterface $adapter, EmailService $emailService): MailAdapterInterface
    {
        return $this->adapters[$emailService->id] = $adapter;
    }

    /**
     * @throws InvalidArgumentException
     */
    private function resolve(EmailService $emailService): MailAdapterInterface
    {
        if (! $emailServiceType = EmailServiceType::resolve($emailService->type_id)) {
            throw new InvalidArgumentException("Unable to resolve mail provider type from ID [{$emailService->type_id}].");
        }

        $adapterClass = self::$adapterMap[$emailService->type_id] ?? null;

        if (! $adapterClass) {
            throw new InvalidArgumentException("Mail adapter type [{$emailServiceType}] is not supported.");
        }

        return new $adapterClass($emailService->settings);
    }
}
