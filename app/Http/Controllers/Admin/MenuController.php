<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::whereNull('parent_id')
            ->with(['children', 'roles'])
            ->orderBy('order')
            ->get();
        $roles = Role::all();

        return view('admin.menus.index', compact('menus', 'roles'));
    }

    public function store(MenuRequest $request)
    {
        $menu = Menu::create($request->validated());

        if ($request->roles) {
            $menu->roles()->sync($request->roles);
        }

        return response()->json(['success' => true]);
    }

    public function update(MenuRequest $request, Menu $menu)
    {
        $menu->update($request->validated());

        if ($request->roles) {
            $menu->roles()->sync($request->roles);
        }

        return response()->json(['success' => true]);
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();
        return response()->json(['success' => true]);
    }

    public function updateOrder(Request $request)
    {
        try {
            $items = $request->input('items', []);
            foreach ($items as $index => $item) {
                $menu = Menu::find($item['id']);
                if ($menu) {
                    $menu->parent_id = null;
                    $menu->order = $index + 1;
                    $menu->save();

                    if (isset($item['children'])) {
                        $this->updateChildrenOrder($item['children'], $menu->id);
                    }
                }
            }

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    private function updateChildrenOrder($children, $parentId, $order = 1)
    {
        foreach ($children as $index => $child) {
            $menu = Menu::find($child['id']);
            if ($menu) {
                $menu->parent_id = $parentId;
                $menu->order = $order + $index;
                $menu->save();

                if (isset($child['children'])) {
                    $this->updateChildrenOrder($child['children'], $menu->id);
                }
            }
        }
    }
}
