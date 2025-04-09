<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Requests\StoreRoleRequest as RequestsStoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest as RequestsUpdateRoleRequest;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.roles.index');
    }

    public function getData()
    {
        $roles = Role::with('permissions');

        return DataTables::of($roles)
            ->addIndexColumn()
            ->addColumn('permissions', function ($role) {
                return view('admin.roles.permissions', compact('role'));
            })
            ->addColumn('action', function ($role) {
                return view('admin.roles.action', compact('role'));
            })
            ->rawColumns(['permissions', 'action'])
            ->make(true);
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(RequestsStoreRoleRequest $request)
    {
        $role = Role::create(['name' => $request->validated()['name']]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        return view('admin.roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(RequestsUpdateRoleRequest $request, Role $role)
    {
        $role->update(['name' => $request->validated()['name']]);
        $role->syncPermissions($request->permissions);

        return redirect()->route('admin.roles.index');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['success' => true]);
    }
}
