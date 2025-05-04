<?php

declare(strict_types=1);

namespace App\Http\Controllers\Campaigns;

use Exception;
use Illuminate\Http\RedirectResponse;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Models\CampaignStatus;
use App\Repositories\Campaigns\CampaignTenantRepositoryInterface;

class CampaignDuplicateController extends Controller
{
    /** @var CampaignTenantRepositoryInterface */
    protected $campaigns;

    public function __construct(CampaignTenantRepositoryInterface $campaigns)
    {
        $this->campaigns = $campaigns;
    }

    /**
     * Duplicate a campaign.
     *
     * @throws Exception
     */
    public function duplicate(int $campaignId): RedirectResponse
    {
        $campaign = $this->campaigns->find(Sendportal::currentWorkspaceId(), $campaignId);

        return redirect()->route('sendportal.campaigns.create')->withInput([
            'name' => $campaign->name . ' - Duplicate',
            'status_id' => CampaignStatus::STATUS_DRAFT,
            'template_id' => $campaign->template_id,
            'email_service_id' => $campaign->email_service_id,
            'subject' => $campaign->subject,
            'content' => $campaign->content,
            'from_name' => $campaign->from_name,
            'from_email' => $campaign->from_email,
        ]);
    }
}
