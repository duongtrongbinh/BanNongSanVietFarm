<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Repositories\CategoryRepository;
use App\Http\Requests\CategoryCreateRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    const PATH_VIEW = 'admin.categories.';
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $categories = $this->categoryRepository->getLatestAll();

        return view(self::PATH_VIEW . __FUNCTION__, compact('categories'));
    }

    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__);
    }

    public function store(CategoryCreateRequest $request)
    {
        $this->categoryRepository->create($request->all());

        return redirect()
            ->route('categories.index')
            ->with('status', 'Success');
    }

    public function show(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    public function edit(Category $category)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('category'));
    }

    public function update(CategoryCreateRequest $request, Category $category)
    {
        $this->categoryRepository->update($category->id, $request->all());

        return back()
            ->with('status', 'Success');
    }

    public function delete(Category $category)
    {
        $this->categoryRepository->delete($category->id);

        return response()->json(true);
        
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->destroy($category->id);

        return response()->json(true);
    }
}
