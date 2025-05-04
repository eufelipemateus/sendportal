<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Controllers\Controller;
use App\Http\Resources\Workspace as WorkspaceResource;
use App\Repositories\WorkspacesRepository;

class WorkspacesController extends Controller
{
    /** @var WorkspacesRepository */
    private $workspaces;

    public function __construct(WorkspacesRepository $workspaces)
    {
        $this->workspaces = $workspaces;
    }

    /**
     * @throws Exception
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $workspaces = $this->workspaces->workspacesForUser($request->user());

        return WorkspaceResource::collection($workspaces);
    }
}
