<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function getData()
    {
        $users = User::with('roles');

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('roles', function ($user) {
                if ($user->roles->isEmpty()) {
                    return '<span class="badge badge-danger">No Role Assigned !</span>';
                }

                return $user->roles->pluck('name')
                    ->map(function ($role) {
                        return '<span class="badge badge-info">' . $role . '</span>';
                    })
                    ->implode(' ');
            })
            ->addColumn('created_at', function ($user) {
                return $user->created_at->format('Y-m-d H:i:s');
            })
            ->addColumn('action', function ($user) {
                return view('admin.users.action', compact('user'));
            })
            ->rawColumns(['roles', 'action'])
            ->make(true);
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());
        $user->syncRoles($request->roles);
        return redirect()->route('admin.users.index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $userRole = $user->roles->first();
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $validated = $request->validated();

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();
        $user->syncRoles($request->roles);

        return redirect()->route('admin.users.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true]);
    }
}
