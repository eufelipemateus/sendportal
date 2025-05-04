<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SubscriberTagDestroyRequest;
use App\Http\Requests\Api\SubscriberTagStoreRequest;
use App\Http\Requests\Api\SubscriberTagUpdateRequest;
use App\Http\Resources\Tag as TagResource;
use App\Repositories\Subscribers\SubscriberTenantRepositoryInterface;
use App\Services\Subscribers\Tags\ApiSubscriberTagService;

class SubscriberTagsController extends Controller
{
    /** @var SubscriberTenantRepositoryInterface */
    private $subscribers;

    /** @var ApiSubscriberTagService */
    private $apiService;

    public function __construct(
        SubscriberTenantRepositoryInterface $subscribers,
        ApiSubscriberTagService $apiService
    ) {
        $this->subscribers = $subscribers;
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function index(int $subscriberId): AnonymousResourceCollection
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $subscriber = $this->subscribers->find($workspaceId, $subscriberId, ['tags']);

        return TagResource::collection($subscriber->tags);
    }

    /**
     * @throws Exception
     */
    public function store(SubscriberTagStoreRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $tags = $this->apiService->store($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }

    /**
     * @throws Exception
     */
    public function update(SubscriberTagUpdateRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $tags = $this->apiService->update($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }

    /**
     * @throws Exception
     */
    public function destroy(SubscriberTagDestroyRequest $request, int $subscriberId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $tags = $this->apiService->destroy($workspaceId, $subscriberId, collect($input['tags']));

        return TagResource::collection($tags);
    }
}
