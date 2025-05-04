<?php

declare(strict_types=1);

namespace App\Http\Controllers\Campaigns;

use Exception;
use Illuminate\Http\RedirectResponse;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\CampaignTestRequest;
use App\Services\Messages\DispatchTestMessage;

class CampaignTestController extends Controller
{
    /** @var DispatchTestMessage */
    protected $dispatchTestMessage;

    public function __construct(DispatchTestMessage $dispatchTestMessage)
    {
        $this->dispatchTestMessage = $dispatchTestMessage;
    }

    /**
     * @throws Exception
     */
    public function handle(CampaignTestRequest $request, int $campaignId): RedirectResponse
    {
        $messageId = $this->dispatchTestMessage->handle(Sendportal::currentWorkspaceId(), $campaignId, $request->get('recipient_email'));

        if (! $messageId) {
            return redirect()->route('sendportal.campaigns.preview', $campaignId)
                ->withInput()
                ->with(['error', __('Failed to dispatch test email.')]);
        }

        return redirect()->route('sendportal.campaigns.preview', $campaignId)
            ->withInput()
            ->with(['success' => __('The test email has been dispatched.')]);
    }
}
