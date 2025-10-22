<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus semua data sebelumnya
        Menu::truncate();

        // Fungsi rekursif untuk membuat tree
        $createMenu = function ($name, $parent = null, $children = []) use (&$createMenu) {
            $menu = Menu::create([
                'id' => Str::uuid(),
                'name' => $name,
                'parent_id' => $parent?->id,
                'depth' => $parent ? $parent->depth + 1 : 0,
            ]);

            foreach ($children as $childName => $childChildren) {
                if (is_array($childChildren)) {
                    $createMenu($childName, $menu, $childChildren);
                } else {
                    $createMenu($childChildren, $menu, []);
                }
            }

            return $menu;
        };

        // Struktur menu berdasarkan UI
        $menuTree = [
            'System Management' => [
                'Systems' => [
                    'System Code' => [
                        'Code Registration',
                        'Code Registration - 2'
                    ],
                    'Properties',
                    'Menus' => [
                        'Menu Registration'
                    ],
                    'API List' => [
                        'API Registration',
                        'API Edit'
                    ],
                ],
                'Users & Groups' => [
                    'Users' => [
                        'User Account Registration'
                    ],
                    'Groups' => [
                        'User Group Registration'
                    ],
                ],
                '사용자 승인' => [
                    '사용자 승인 상세'
                ],
            ],
            'Competition' => [],
        ];

        foreach ($menuTree as $menuName => $children) {
            $createMenu($menuName, null, $children);
        }
    }
}