<?php

namespace App\Services;

use App\Models\Menu;
use App\Repositories\MenuRepository;
use Illuminate\Support\Facades\DB;

class MenuService
{
    public function __construct(
        protected MenuRepository $repository
    ) {}

    public function getTree()
    {
        return $this->repository->allTree();
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            if (!empty($data['parent_id'])) {
                $parent = Menu::findOrFail($data['parent_id']);
                $data['depth'] = $parent->depth + 1;
            } else {
                $data['depth'] = 0;
            }

            return $this->repository->create($data);
        });
    }

    public function update(string $id, array $data)
    {
        $menu = $this->repository->find($id);
        return $this->repository->update($menu, $data);
    }

    public function delete(string $id)
    {
        $menu = $this->repository->find($id);
        return $this->repository->delete($menu);
    }
}