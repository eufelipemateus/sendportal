<?php

declare(strict_types=1);

namespace Tests\Feature\Webview;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Facades\Sendportal;
use App\Models\Campaign;
use App\Models\Message;
use Tests\TestCase;

class WebviewControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_message_can_be_seen_in_the_webview()
    {
        // given
        $campaign = Campaign::factory()->withContent()->create(['workspace_id' => Sendportal::currentWorkspaceId()]);
        $message = Message::factory()->create(['source_id' => $campaign->id, 'workspace_id' => Sendportal::currentWorkspaceId()]);

        // when
        $response = $this->get(route('sendportal.webview.show', $message->hash));

        // then
        $response->assertOk();
    }
}
