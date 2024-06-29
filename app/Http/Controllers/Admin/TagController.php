<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\ProductRepository;
use App\Http\Repositories\TagRepository;
use App\Http\Requests\TagCreateRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    const PATH_VIEW = 'admin.tags.';
    protected $tagRepository;
    protected $productRepository;

    public function __construct(TagRepository $tagRepository, ProductRepository $productRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $tags = $this->tagRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('tags'));
    }

    public function create()
    {   
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(TagCreateRequest $request)
    {
        $this->tagRepository->create($request->validated());

        return redirect()
            ->route('tags.index')
            ->with('status', 'Success');
    }

    public function show(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('tag'));
    }

    public function update(TagCreateRequest $request, Tag $tag)
    {
        $this->tagRepository->update($tag->id, $request->validated());

        return back()
            ->with('status', 'Success');
    }

    public function delete(Tag $tag)
    {
        $this->tagRepository->delete($tag->id);

        return response()->json(true);
        
    }

    public function destroy(Tag $tag)
    {
        $this->tagRepository->destroy($tag->id);

        return response()->json(true);
    }
}
