<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MenuService;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function __construct(
        protected MenuService $service
    ) {}

    public function index()
    {
        return response()->json($this->service->getTree());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:255|unique:menus,code',
            'parent_id' => 'nullable|uuid|exists:menus,id',
            'order' => 'nullable|integer|min:0',
        ]);

        return response()->json($this->service->create($data), 201);
    }

    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'code' => 'nullable|string|max:255|unique:menus,code,' . $id,
            'parent_id' => 'nullable|uuid|exists:menus,id',
            'order' => 'nullable|integer|min:0',
        ]);

        return response()->json($this->service->update($id, $data));
    }

    public function destroy(string $id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Menu deleted successfully']);
    }
}