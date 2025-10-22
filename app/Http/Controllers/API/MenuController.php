<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Services\MenuService;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $service
    ) {}

    public function index()
    {
        $menus = $this->service->getTree();
        return MenuResource::collection($menus);
    }

    public function store(MenuRequest $request)
    {
        $menu = $this->service->create($request->validated());
        return new MenuResource($menu->load('children'));
    }

    public function update(MenuRequest $request, string $id)
    {
        $menu = $this->service->update($id, $request->validated());
        return new MenuResource($menu->load('children'));
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Menu deleted successfully']);
    }
}