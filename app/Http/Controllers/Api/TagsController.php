<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagStoreRequest;
use App\Http\Requests\Api\TagUpdateRequest;
use App\Http\Resources\Tag as TagResource;
use App\Repositories\TagTenantRepository;
use App\Services\Tags\ApiTagService;

class TagsController extends Controller
{
    /** @var TagTenantRepository */
    private $tags;

    /** @var ApiTagService */
    private $apiService;

    public function __construct(
        TagTenantRepository $tags,
        ApiTagService $apiService
    ) {
        $this->tags = $tags;
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function index(): AnonymousResourceCollection
    {
        $workspaceId = Sendportal::currentWorkspaceId();

        return TagResource::collection(
            $this->tags->paginate($workspaceId, 'name', [], request()->get('per_page', 25))
        );
    }

    /**
     * @throws Exception
     */
    public function store(TagStoreRequest $request): TagResource
    {
        $input = $request->validated();
        $workspaceId = Sendportal::currentWorkspaceId();
        $tag = $this->apiService->store($workspaceId, collect($input));

        $tag->load('subscribers');

        return new TagResource($tag);
    }

    /**
     * @throws Exception
     */
    public function show(int $id): TagResource
    {
        $workspaceId = Sendportal::currentWorkspaceId();

        return new TagResource($this->tags->find($workspaceId, $id));
    }

    /**
     * @throws Exception
     */
    public function update(TagUpdateRequest $request, int $id): TagResource
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $tag = $this->tags->update($workspaceId, $id, $request->validated());

        return new TagResource($tag);
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): Response
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $this->tags->destroy($workspaceId, $id);

        return response(null, 204);
    }
}
