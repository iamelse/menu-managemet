<?php

namespace App\Repositories;

use App\Models\Menu;

class MenuRepository
{
    public function allTree()
    {
        return Menu::with('children.children.children')->root()->get();
    }

    public function find($id): ?Menu
    {
        return Menu::with('children')->findOrFail($id);
    }

    public function create(array $data): Menu
    {
        $menu = Menu::create($data);
        return $menu->fresh(['children']);
    }

    public function update(Menu $menu, array $data): Menu
    {
        $menu->update($data);
        return $menu->fresh(['children']);
    }

    public function delete(Menu $menu): bool
    {
        return $menu->delete();
    }
}