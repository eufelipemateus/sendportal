<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TemplateStoreRequest;
use App\Http\Requests\Api\TemplateUpdateRequest;
use App\Http\Resources\Template as TemplateResource;
use App\Repositories\TemplateTenantRepository;
use App\Services\Templates\TemplateService;

class TemplatesController extends Controller
{
    /** @var TemplateTenantRepository */
    private $templates;

    /** @var TemplateService */
    private $service;

    public function __construct(TemplateTenantRepository $templates, TemplateService $service)
    {
        $this->templates = $templates;
        $this->service = $service;
    }

    /**
     * @throws Exception
     */
    public function index(): AnonymousResourceCollection
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $templates = $this->templates->paginate($workspaceId, 'name');

        return TemplateResource::collection($templates);
    }


    /**
     * @throws Exception
     */
    public function show(int $id): TemplateResource
    {
        $workspaceId = Sendportal::currentWorkspaceId();

        return new TemplateResource($this->templates->find($workspaceId, $id));
    }

    /**
     * @throws Exception
     */
    public function store(TemplateStoreRequest $request): TemplateResource
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $template = $this->service->store($workspaceId, $request->validated());

        return new TemplateResource($template);
    }

    /**
     * @throws Exception
     */
    public function update(TemplateUpdateRequest $request, int $id): TemplateResource
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $template = $this->service->update($workspaceId, $id, $request->validated());

        return new TemplateResource($template);
    }

    /**
     * @throws \Throwable
     */
    public function destroy(int $id): Response
    {
        $workspaceId = Sendportal::currentWorkspaceId();
        $this->service->delete($workspaceId, $id);

        return response(null, 204);
    }
}
