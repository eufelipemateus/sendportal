<?php

declare(strict_types=1);

namespace App\Http\Controllers\Tags;

use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Facades\Sendportal;
use App\Http\Controllers\Controller;
use App\Http\Requests\TagStoreRequest;
use App\Http\Requests\TagUpdateRequest;
use App\Repositories\TagTenantRepository;

class TagsController extends Controller
{
    /** @var TagTenantRepository */
    private $tagRepository;

    public function __construct(TagTenantRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @throws Exception
     */
    public function index(): View
    {
        $tags = $this->tagRepository->paginate(Sendportal::currentWorkspaceId(), 'name');

        return view('tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('tags.create');
    }

    /**
     * @throws Exception
     */
    public function store(TagStoreRequest $request): RedirectResponse
    {
        $this->tagRepository->store(Sendportal::currentWorkspaceId(), $request->all());

        return redirect()->route('sendportal.tags.index');
    }

    /**
     * @throws Exception
     */
    public function edit(int $id): View
    {
        $tag = $this->tagRepository->find(Sendportal::currentWorkspaceId(), $id, ['subscribers']);

        return view('tags.edit', compact('tag'));
    }

    /**
     * @throws Exception
     */
    public function update(int $id, TagUpdateRequest $request): RedirectResponse
    {
        $this->tagRepository->update(Sendportal::currentWorkspaceId(), $id, $request->all());

        return redirect()->route('sendportal.tags.index');
    }

    /**
     * @throws Exception
     */
    public function destroy(int $id): RedirectResponse
    {
        $this->tagRepository->destroy(Sendportal::currentWorkspaceId(), $id);

        return redirect()->route('sendportal.tags.index');
    }
}
