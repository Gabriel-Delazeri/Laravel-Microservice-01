<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateCategory;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{
    protected object $repository;

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->repository = $model;
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = $this->repository->get();

        return response()->json(CategoryResource::collection($categories));
    }

    /**
     * @param StoreUpdateCategory $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreUpdateCategory $request)
    {
        $category = $this->repository->create($request->validated());

        return response()->json([
            new CategoryResource($category)
        ]);
    }

    /**
     * @param  string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUpdateCategory $request
     * @param  string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(StoreUpdateCategory $request, $url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->update($request->validated());

        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($url)
    {
        $category = $this->repository->where('url', $url)->firstOrFail();

        $category->delete();

        return response()->json([], 204);
    }
}
