<?php

declare(strict_types=1);

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use App\Facades\Sendportal;
use App\Models\Campaign;
use App\Models\CampaignStatus;
use App\Repositories\Campaigns\CampaignTenantRepositoryInterface;

class CampaignDispatchRequest extends FormRequest
{
    /**
     * @var CampaignTenantRepositoryInterface
     */
    protected $campaigns;

    /**
     * @var Campaign
     */
    protected $campaign;

    public function __construct(CampaignTenantRepositoryInterface $campaigns)
    {
        parent::__construct();

        $this->campaigns = $campaigns;

        Validator::extendImplicit('valid_status', function ($attribute, $value, $parameters, $validator) {
            return $this->getCampaign()->status_id === CampaignStatus::STATUS_DRAFT;
        });
    }

    /**
     * @param array $relations
     * @return Campaign
     * @throws \Exception
     */
    public function getCampaign(array $relations = []): Campaign
    {
        return $this->campaign = $this->campaigns->find(Sendportal::currentWorkspaceId(), $this->id, $relations);
    }

    public function rules()
    {
        return [
            'status_id' => 'valid_status',
        ];
    }

    public function messages(): array
    {
        return [
            'valid_status' => __('The campaign must have a status of draft to be dispatched'),
        ];
    }
}
