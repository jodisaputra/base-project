<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Permission\StorePermissionRequest;
use App\Http\Requests\Permission\UpdatePermissionRequest;
use App\Http\Requests\StorePermissionRequest as RequestsStorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest as RequestsUpdatePermissionRequest;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.permissions.index');
    }

    public function getData()
    {
        $permissions = Permission::query();

        return DataTables::of($permissions)
            ->addIndexColumn()
            ->addColumn('guard_name', function ($permission) {
                return '<span class="badge badge-info">' . $permission->guard_name . '</span>';
            })
            ->addColumn('action', function ($permission) {
                return view('admin.permissions.action', compact('permission'));
            })
            ->rawColumns(['guard_name', 'action'])
            ->make(true);
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(RequestsStorePermissionRequest $request)
    {
        Permission::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(RequestsUpdatePermissionRequest $request, Permission $permission)
    {
        $permission->update([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        return redirect()->route('admin.permissions.index')
            ->with('success', 'Permission updated successfully');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return response()->json(['success' => true]);
    }
}
