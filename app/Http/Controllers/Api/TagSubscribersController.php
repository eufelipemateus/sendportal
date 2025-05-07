<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagSubscriberDestroyRequest;
use App\Http\Requests\Api\TagSubscriberStoreRequest;
use App\Http\Requests\Api\TagSubscriberUpdateRequest;
use App\Http\Resources\Subscriber as SubscriberResource;
use App\Repositories\TagTenantRepository;
use App\Services\Tags\ApiTagSubscriberService;

class TagSubscribersController extends Controller
{
    /** @var TagTenantRepository */
    private $tags;

    /** @var ApiTagSubscriberService */
    private $apiService;

    public function __construct(
        TagTenantRepository $tags,
        ApiTagSubscriberService $apiService
    ) {
        $this->tags = $tags;
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function index(int $tagId): AnonymousResourceCollection
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $tag = $this->tags->find($workspaceId, $tagId, ['subscribers']);

        return SubscriberResource::collection($tag->subscribers);
    }

    /**
     * @throws Exception
     */
    public function store(TagSubscriberStoreRequest $request, int $tagId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $subscribers = $this->apiService->store($workspaceId, $tagId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }

    /**
     * @throws Exception
     */
    public function update(TagSubscriberUpdateRequest $request, int $tagId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $subscribers = $this->apiService->update($workspaceId, $tagId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }

    /**
     * @throws Exception
     */
    public function destroy(TagSubscriberDestroyRequest $request, int $tagId): AnonymousResourceCollection
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $subscribers = $this->apiService->destroy($workspaceId, $tagId, collect($input['subscribers']));

        return SubscriberResource::collection($subscribers);
    }
}
