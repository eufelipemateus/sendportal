<?php

declare(strict_types=1);

namespace Tests\Unit\Factories;

use InvalidArgumentException;
use App\Adapters\MailgunMailAdapter;
use App\Adapters\PostmarkMailAdapter;
use App\Adapters\SendgridMailAdapter;
use App\Adapters\SesMailAdapter;
use App\Factories\MailAdapterFactory;
use App\Models\EmailService;
use App\Models\EmailServiceType;
use Tests\TestCase;

class MailAdapterFactoryTest extends TestCase
{
    /** @test */
    public function can_build_a_mailgun_adapter()
    {
        // given
        $emailService = EmailService::factory()->make(['workspace_id' => null, 'type_id' => EmailServiceType::MAILGUN]);
        $adapterFactory = new MailAdapterFactory();

        // when
        $adapter = $adapterFactory->adapter($emailService);

        // then
        self::assertEquals(MailgunMailAdapter::class, get_class($adapter));
    }

    /** @test */
    public function can_build_a_sendgrid_adapter()
    {
        // given
        $emailService = EmailService::factory()->make(['workspace_id' => null, 'type_id' => EmailServiceType::SENDGRID]);
        $adapterFactory = new MailAdapterFactory();

        // when
        $adapter = $adapterFactory->adapter($emailService);

        // then
        self::assertEquals(SendgridMailAdapter::class, get_class($adapter));
    }

    /** @test */
    public function can_build_a_postmark_adapter()
    {
        // given
        $emailService = EmailService::factory()->make(['workspace_id' => null, 'type_id' => EmailServiceType::POSTMARK]);
        $adapterFactory = new MailAdapterFactory();

        // when
        $adapter = $adapterFactory->adapter($emailService);

        // then
        self::assertEquals(PostmarkMailAdapter::class, get_class($adapter));
    }

    /** @test */
    public function can_build_an_ses_adapter()
    {
        // given
        $emailService = EmailService::factory()->make(['workspace_id' => null, 'type_id' => EmailServiceType::SES]);
        $adapterFactory = new MailAdapterFactory();

        // when
        $adapter = $adapterFactory->adapter($emailService);

        // then
        self::assertEquals(SesMailAdapter::class, get_class($adapter));
    }

    /** @test */
    public function an_exception_is_thrown_when_building_an_unknown_adapater()
    {
        // given
        $emailService = EmailService::factory()->make(['workspace_id' => null, 'type_id' => 100]);
        $adapterFactory = new MailAdapterFactory();

        // then
        $this->expectException(InvalidArgumentException::class);

        // when
        $adapterFactory->adapter($emailService);
    }
}
