<?php

declare(strict_types=1);

namespace Tests;

use App\Facades\Sendportal;
use App\Models\Campaign;
use App\Models\EmailService;
use App\Models\Subscriber;
use App\Models\Tag;

trait SendportalTestSupportTrait
{
    protected function createEmailService(): EmailService
    {
        return EmailService::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }

    protected function createCampaign(EmailService $emailService): Campaign
    {
        return Campaign::factory()
            ->withContent()
            ->sent()
            ->create([
                'workspace_id' => Sendportal::currentWorkspaceId(),
                'email_service_id' => $emailService->id,
            ]);
    }

    protected function createTag(): Tag
    {
        return Tag::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }

    protected function createSubscriber(): Subscriber
    {
        return Subscriber::factory()->create([
            'workspace_id' => Sendportal::currentWorkspaceId(),
        ]);
    }
}
